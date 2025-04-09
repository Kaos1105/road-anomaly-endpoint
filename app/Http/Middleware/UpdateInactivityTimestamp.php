<?php

namespace App\Http\Middleware;

use App\Models\PersonalAccessToken;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateInactivityTimestamp
{
    public function handle(Request $request, Closure $next): Response
    {
//        dd(\Auth::user()->currentAccessToken());
        $response = $next($request);
        $login = \Auth::user();
        if ($login) {
            /**
             * @var $currentAccessToken PersonalAccessToken
             */
            $currentAccessToken = $login->currentAccessToken();
            if ($currentAccessToken) {
                PersonalAccessToken::find($currentAccessToken->id)?->update([
                    'expired_inactivity_at' => Carbon::now()->addMinutes(config('sanctum.last_used_expiration'))
                ]);
            }
        }
        return $response;
    }
}
