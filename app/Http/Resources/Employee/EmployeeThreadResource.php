<?php

namespace App\Http\Resources\Employee;

use App\Http\Resources\ChatThread\ChatThreadUserResource;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Employee
 */
class EmployeeThreadResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'code' => $this->code,
            'chat_thread' => $this->whenLoaded('chatThreads', fn() => ChatThreadUserResource::make($this->chatThreads->first()))
        ];
    }
}
