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
                'dateTime' => ['required', 'date'],
            ]
        );

        $datetime = new DateTime($request->dateTime);

        $result = $doctor->addAppointment(
            $request->user()->concrete,
            new DateTime($request->dateTime),
        );
        if (!$result) {
            abort(400, 'Invalid appointment datetime');
        }

        return response('Appointment created', 200);
    }

    public function cancel(Appointment $appointment, Request $request)
    {
        $this->authorize('delete', $appointment);

        if (!$appointment->canBeCancelled()) {
            throw ValidationException::withMessages([
                __('appointments.cantBeCancelled'),
            ]);
        }

        $appointment->status = AppointmentStatus::Cancelled;
        $appointment->save();

        return response('cancelled', 200);
    }

    public function confirm(Appointment $appointment)
    {
        $this->authorize('update', $appointment);

        if ($appointment->status != AppointmentStatus::Created) {
            abort(400, 'Cannot confirm this appointment');
        }

        $appointment->status = 'confirmed';
        $appointment->save();

        Appointment::whereDate('date_time', $appointment->date_time)
            ->whereTime('date_time', $appointment->date_time)
            ->whereNot('id', $appointment->id)
            ->each(function ($appointment) {
                $appointment->status = 'cancelled';
            });

        return response('confirmed', 200);
    }

    public function success(Appointment $appointment, Request $request)
    {
        $this->authorize('update', $appointment);
        if ($appointment->status != AppointmentStatus::Confirmed){
            abort(400, 'Cannot confirm this appointment');
        }
        $appointment->status = AppointmentStatus::Successful;
        $appointment->save();
        
        return response('set successful', 200);
    }

    public function didntCome(Appointment $appointment, Request $request)
    {
        $this->authorize('update', $appointment);
        if ($appointment->status != AppointmentStatus::Confirmed){
            abort(400, 'Cannot confirm this appointment');
        }
        $appointment->status = AppointmentStatus::DidntCome;
        $appointment->save();
        
        return response('set didnt come', 200);
    }
}
