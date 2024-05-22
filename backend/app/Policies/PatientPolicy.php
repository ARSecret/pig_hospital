<?php

namespace App\Policies;

use App\Models\Doctor;
use App\Models\Nurse;
use App\Models\Patient;
use App\Models\User;

class PatientPolicy
{
    private function hasAccess(User $user, Patient $patient): bool
    {
        $concrete = $user->concrete;
        if ($concrete == $patient) {
            return true;
        }

        if (
            $concrete instanceof Doctor
            && $concrete->getPatients()->contains($patient)
        ) {
            return true;
        }

        if (
            $concrete instanceof Nurse
            && $concrete->doctor->getPatients()->contains($patient)
        ) {
            return true;
        }

        return false;
    }

    public function view(User $user, Patient $patient): bool
    {
        return $this->hasAccess($user, $patient);
    }

    public function viewAppointments(User $user, Patient $patient): bool
    {
        return $this->hasAccess($user, $patient);
    }

    public function viewCaseRecords(User $user, Patient $patient): bool
    {
        return $this->hasAccess($user, $patient);
    }

    public function createCaseRecord(User $user, Patient $patient): bool
    {
        if ($user->concrete instanceof Doctor && $user->concrete->getPatients()->contains($patient)) {
            return true;
        }

        return false;
    }
}
