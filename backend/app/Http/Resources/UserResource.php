<?php

namespace App\Http\Resources;

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
            'login' => $this->login,
            'email' => $this->email,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'patronymic' => $this->whenNotNull('patronymic'),
            'full_name' => $this->full_name,
            'role' => $this->role,
            'doctor' => $this->doctor ? new DoctorResource($this->doctor) : null,
            'patient' => $this->patient ? new PatientResource($this->patient) : null,
        ];
    }
}
