<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use DateTime;

use App\Models\Doctor;
use App\Models\Appointment;
use App\Http\Resources\UserDoctorResource;
use App\Http\Resources\UserPatientResource;
use App\Http\Resources\AppointmentResource;
use App\Http\Resources\PublicDoctorResource;
use App\Models\Speciality;
use Illuminate\Validation\Rule;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Doctor::class);

        $request->validate([
            'specialityId' => [
                Rule::exists(Speciality::class, 'id'),
            ],
        ]);

        $doctors = Doctor::all()->sortBy('speciality_id');
        if (isset($request->specialityId)) {
            $doctors = $doctors->where('speciality_id', $request->specialityId);
        }

        return PublicDoctorResource::collection($doctors);
    }

    // public function store(Request $request)
    // {
    //     Gate::authorize('create-doctor');
    // }

    public function show(Doctor $doctor)
    {
        $this->authorize('view', $doctor);

        return new PublicDoctorResource($doctor);
    }

    // public function update(Request $request, string $id)
    // {
    //     Gate::authorize('update-doctor', $id);

    //     //TODO
    // }

    public function indexPatients(Request $request, Doctor $doctor)
    {
        $this->authorize('viewPatients', $doctor);

        return UserPatientResource::collection($doctor->getPatients()->sortBy('full_name'));
    }

    public function indexAppointments(Request $request, Doctor $doctor)
    {
        $this->authorize('viewAppointments', $doctor);

        $request->validate(
            [
                'date' => ['required', 'date'],
            ]
        );

        return AppointmentResource::collection(
            $doctor->appointments()
                ->whereDate('date_time', $request->date)
                ->get()
                ->sortBy('date_time')
        );
    }

    public function indexAvailableAppointmentTimes(Request $request, Doctor $doctor)
    {
        $this->authorize('viewAvailableAppointments', Doctor::class);

        $request->validate(
            [
                'date' => ['required', 'date'],
            ]
        );

        return [
            'data' => array_map(
                fn ($datetime) => $datetime->format(DateTime::ISO8601),
                $doctor->getAvailableAppointmentDatetimes(new DateTime($request->date))
            ),
        ];
    }
}
