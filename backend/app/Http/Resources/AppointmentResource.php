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
            'datetime' => $this->datetime->format(DateTime::ISO8601),
            'status' => $this->status,
            'pretty_status' => $this->pretty_status,
            'can_be_cancelled' => $this->canBeCancelled(),
            'can_be_confirmed' => $this->canBeConfirmed(),
            'can_be_finished' => $this->canBeFinished(),
            'patient' => [
                'id' => $this->patient->id,
                'full_name' => $this->patient->user->full_name,
            ],
            'doctor' => [
                'id' => $this->doctor->id,
                'full_name' => $this->doctor->user->full_name,
                'speciality' => [
                    'id' => $this->doctor->speciality->id,
                    'name' => $this->doctor->speciality->name,
                ],
            ],
        ];
    }
}
