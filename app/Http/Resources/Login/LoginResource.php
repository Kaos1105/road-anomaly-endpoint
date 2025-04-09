<?php

namespace App\Http\Resources\Login;

use App\Models\Login;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Login
 */
class LoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'employee_id' => $this->employee_id,
            'login_id' => $this->login_id,
            'password_decrypt' => $this->password_decrypt,
        ];
    }
}
