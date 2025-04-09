<?php

namespace App\Http\Resources\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 */
class UserItemResource extends JsonResource
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
            'login_id' => $this->login_id,
            'password' => $this->login_id ? '********' : '',
            'name' => $this->name,
            'email' => $this->email,
            'use_classification' => $this->use_classification,
            'statistic_classification' => $this->statistic_classification,
        ];
    }
}
