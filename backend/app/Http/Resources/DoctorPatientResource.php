<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorPatientResource extends JsonResource
{
    /**
     * No username and email
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'patronymic' => $this->whenNotNull($this->patronymic),
            'fullName' => $this->full_name,
            'gender' => $this->user->gender,
            'birthdate' => $this->birthdate,
            'age' => $this->getAge(),
        ];
    }
}
