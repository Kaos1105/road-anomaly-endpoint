<?php

namespace App\Http\Resources\User;

use App\Enums\User\PasswordEnum;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'login_id' => $this->login_id,
            'password' => $this->login_id ? PasswordEnum::DEFAULT_DISPLAY : '',
            'name' => $this->name,
        ];
    }
}
