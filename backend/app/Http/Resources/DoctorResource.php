<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
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
            'first_name' => $this->user->first_name,
            'last_name' => $this->user->last_name,
            'full_name' => $this->full_name,
            'patronymic' => $this->whenNotNull($this->user->patronymic),
            'gender' => $this->user->gender,
            'speciality' => [
                'id' => $this->speciality->id,
                'name' => $this->speciality->name,
            ],
            'photo_url' => $this->photo_url,
        ];
    }
}
