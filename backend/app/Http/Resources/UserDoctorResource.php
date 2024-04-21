<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserDoctorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return array_merge(
            (new UserResource($this->user))->toArray($request),
            [
                'role' => 'doctor',
                'speciality' => [
                    'id' => $this->speciality->id,
                    'name' => $this->speciality->name,
                ],
                'photoUrl' => $this->photo_url ? asset($this->photo_url) : null,            ]
        );
    }
}
