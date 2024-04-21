<?php

namespace App\Http\Resources;

use App\Models\Doctor;
use App\Models\Nurse;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'patronymic' => $this->whenNotNull($this->patronymic),
            'fullName' => $this->full_name,
        ];
    }
}
