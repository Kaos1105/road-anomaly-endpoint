<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\DTO\Common\HiraganaData;
use App\Http\DTO\Common\ZipCodeData;
use App\Http\Requests\ZIpCode\HiraganaRequest;
use App\Http\Requests\ZIpCode\LookUpRequest;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class ExternalController extends Controller
{
    public function getZipCodeInfo(LookUpRequest $request): \App\Http\DTO\ResponseData
    {
        $data = $request->validated();

        $response = Http::get('https://zipcloud.ibsnet.co.jp/api/search', [
            'zipcode' => $data['post_code'],
        ]);

        if ($response->successful() && $response->json()['status'] === Response::HTTP_OK) {
            if (empty($response->json()['results'])) {
                return $this->httpUnprocessableContent([
                    'post_code' => __('validation.no_post_code')
                ]);
            }
            return $this->httpOk(ZipCodeData::fromCollection($response->json()['results'])->toArray());
        } else {
            return $this->httpNotFound();
        }
    }
    public function getHiragana(HiraganaRequest $request): \App\Http\DTO\ResponseData
    {
        $data = $request->validated();
        if(empty($data['app_id'])) {
            return $this->httpNotFound();
        }
        $response = Http::post('https://labs.goo.ne.jp/api/hiragana', $data);
        if ($response->successful() && $response->status() === Response::HTTP_OK) {
            return $this->httpOk(HiraganaData::from($response->json()));
        } else {
            return $this->httpNotFound();
        }
    }
}
