<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserPatientResource extends JsonResource
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
                'role' => 'patient',
                'gender' => $this->user->gender,
                'birthdate' => $this->birthdate,
                'age' => $this->getAge(),
            ]
        );
    }
}
