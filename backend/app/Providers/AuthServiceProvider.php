<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\DB;

use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::before(
            function (User $user, string $ability) {
                if ($user->role == 'admin') {
                    return true;
                }
            }
        );

        Gate::define(
            'view-all-doctors', function (?User $user) {
                return true;
            }
        );

        Gate::define(
            'view-doctor-patients', function (User $user, int $toViewDoctorId) {
                if ($user->role == 'doctor') {
                    $selfDoctorId = DB::table('doctors')->where('user_id', $user->id)->value('id');
                } else if ($user->role == 'nurse') {
                    $selfDoctorId = DB::table('nurses')->where('user_id', $user->id)->value('doctor_id');
                } else {
                    return false;
                }

                return $toViewDoctorId == $selfDoctorId;
            }
        );

        Gate::define(
            'view-patient', function (User $user, int $patientId) {
                if ($user->role == 'doctor') {
                    $doctorId = DB::table('doctors')->where('user_id', $user->id)->value('id');
                } else if ($user->role == 'nurse') {
                    $doctorId = DB::table('nurses')->where('user_id', $user->id)->value('doctor_id');
                } else if ($user->role == 'patient') {
                    return DB::table('patients')->where('user_id', $user->id)->value('id') == $patientId;
                } else {
                    return false;
                }

                $hasCases = DB::table('case_records')->where('doctor_id', $doctorId)->where('patient_id', $patientId)->exists();
                $hasAppointments = DB::table('appointments')->where('doctor_id', $doctorId)->where('patient_id', $patientId)->exists();
                return $hasCases || $hasAppointments;
            }
        );

        Gate::define(
            'view-doctor-appointments', function (User $user, int $toViewDoctorId) {
                if ($user->role == 'doctor') {
                    $selfDoctorId = DB::table('doctors')->where('user_id', $user->id)->value('id');
                } else if ($user->role == 'nurse') {
                    $selfDoctorId = DB::table('nurses')->where('user_id', $user->id)->value('doctor_id');
                } else {
                    return false;
                }

                return $toViewDoctorId == $selfDoctorId;
            }
        );

        Gate::define(
            'view-patient-appointments', function (User $user, int $patientId) {
                if ($user->role != 'patient') {
                    return false;
                }
                return $patientId == DB::table('patients')->where('user_id', $user->id)->value('id');
            }
        );

        Gate::define(
            'view-all-specialities', function (?User $user) {
                return true;
            }
        );
    }
}
