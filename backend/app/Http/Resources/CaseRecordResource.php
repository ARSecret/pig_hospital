<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CaseRecordResource extends JsonResource
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
            'date_time' => $this->date_time,
            'doctor' => [
                'id' => $this->doctor->id,
                'fullName' => $this->doctor->full_name,
                'speciality' => [
                    'id' => $this->doctor->speciality->id,
                    'name' => $this->doctor->speciality->name,
                ],
            ],
            'patient' => [
                'id' => $this->patient->id,
                'fullName' => $this->patient->full_name,
            ],
            'text' => $this->text,
        ];
    }
}
