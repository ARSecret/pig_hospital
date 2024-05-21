<?php

namespace App\Http\Resources;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
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
            'dateTime' => $this->date_time->format(DateTime::ISO8601),
            'status' => $this->status,
            'prettyStatus' => $this->status,
            'canBeCancelled' => $this->canBeCancelled(),
            'canBeConfirmed' => $this->canBeConfirmed(),
            'canBeFinished' => $this->canBeFinished(),
            'patient' => [
                'id' => $this->patient->id,
                'fullName' => $this->patient->full_name,
                'age' => $this->patient->getAge(),
            ],
            'doctor' => [
                'id' => $this->doctor->id,
                'fullName' => $this->doctor->full_name,
                'speciality' => [
                    'id' => $this->doctor->speciality->id,
                    'name' => $this->doctor->speciality->name,
                ],
            ],
        ];
    }
}
