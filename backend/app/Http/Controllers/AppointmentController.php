<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Enums\AppointmentStatus;
use App\Models\Patient;
use Database\Seeders\AppointmentSeeder;

class AppointmentController extends Controller
{
    

    public function store(Request $request, Doctor $doctor)
    {
        $this->authorize('create', Appointment::class);

        $request->validate(
            [
                'datetime' => ['required', 'date'],
            ]
        );

        $datetime = new DateTime($request->datetime);

        $result = $doctor->addAppointment(
            $request->user()->patient,
            new DateTime($request->datetime),
        );
        if (!$result) {
            abort(400, 'Invalid appointment datetime');
        }

        return response('Appointment created', 200);
    }

    public function destroy(Appointment $appointment, Request $request)
    {
        $this->authorize('delete', $appointment);

        if (!$appointment->canBeCancelled()) {
            throw ValidationException::withMessages([
                __('appointments.cantBeCancelled'),
            ]);
        }

        $appointment->status = AppointmentStatus::Cancelled;
        $appointment->save();
    }

    public function confirm(Appointment $appointment)
    {
        $this->authorize('update', $appointment);

        if ($appointment->status != 'created') {
            abort(400, 'Cannot confirm this appointment');
        }

        $appointment->status = 'confirmed';
        $appointment->save();

        Appointment::whereDate('datetime', $appointment->date_time)
            ->whereTime('datetime', $appointment->date_time)
            ->whereNot('id', $appointment->id)
            ->each(function ($appointment) {
                $appointment->status = 'cancelled';
            });

        return response('confirmed', 200);
    }
}
