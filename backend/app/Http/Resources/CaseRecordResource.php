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
            'datetime' => $this->datetime,
            'doctor' => [
                'id' => $this->doctor->id,
                'full_name' => $this->doctor->user->full_name,
                'speciality' => [
                    'id' => $this->doctor->speciality->id,
                    'name' => $this->doctor->speciality->name,
                ],
            ],
            'patient' => [
                'id' => $this->patient->id,
                'full_name' => $this->patient->user->full_name,
            ],
            'text' => $this->text,
        ];
    }
}
