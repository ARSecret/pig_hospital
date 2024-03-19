<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use DateTime;

use App\Models\Doctor;
use App\Models\Appointment;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\PatientResource;
use App\Http\Resources\AppointmentResource;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Doctor::class);

        $doctors = Doctor::all()->sortBy('speciality_id');
        foreach ($request->query() as $key => $value) {
            $doctors = $doctors->where($key, $value);
        }

        return DoctorResource::collection($doctors);
    }

    // public function store(Request $request)
    // {
    //     Gate::authorize('create-doctor');
    // }

    public function show(Doctor $doctor)
    {
        $this->authorize('view', $doctor);

        return new DoctorResource($doctor);
    }

    // public function update(Request $request, string $id)
    // {
    //     Gate::authorize('update-doctor', $id);

    //     //TODO
    // }

    public function indexPatients(Request $request, Doctor $doctor)
    {
        $this->authorize('viewPatients', $doctor);

        return PatientResource::collection($doctor->getPatients()->sortBy('full_name'));
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
                ->whereDate('datetime', $request->date)
                ->get()
                ->sortBy('datetime')
        );
    }

    public function indexAvailableAppointments(Request $request, Doctor $doctor)
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
    
    public function storeAppointment(Request $request, Doctor $doctor)
    {
        $this->authorize('create', Appointment::class);

        $request->validate(
            [
                'datetime' => ['required', 'date'],
            ]
        );

        $datetime = new DateTime($request->datetime);
        error_log(print_r($datetime, true));

        $result = $doctor->addAppointment(
            $request->user()->patient,
            new DateTime($request->datetime),
        );
        if (!$result) {
            abort(400, 'Invalid appointment datetime');
        }

        return response('Appointment created', 200);
    }
}
