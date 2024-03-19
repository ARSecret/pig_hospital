<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;

class AppointmentController extends Controller
{
    public function destroy(Appointment $appointment, Request $request)
    {
        $this->authorize('delete', $appointment);

        if (!$appointment->canBeCancelled()) {
            abort(400, 'Cannot cancel this appointment');
        }

        $appointment->status = 'cancelled';
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

        Appointment::whereDate('datetime', $appointment->datetime)
            ->whereTime('datetime', $appointment->datetime)
            ->whereNot('id', $appointment->id)
            ->each(function ($appointment) {
                $appointment->status = 'cancelled';
            });

        return response('confirmed', 200);
    }
}
