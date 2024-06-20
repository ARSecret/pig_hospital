<?php

use App\Http\Controllers\SpecialityController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Authentication;
use App\Http\Controllers\NewsController;
use App\Http\Resources\UserDoctorResource;
use App\Http\Resources\UserNurseResource;
use App\Http\Resources\UserPatientResource;
use App\Http\Resources\UserResource;
use App\Models\Doctor;
use App\Models\Nurse;
use App\Models\Patient;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth')->get(
    '/user',
    function (Request $request) {
        $concrete = $request->user()->concrete;
        switch ($concrete::class) {
            case Patient::class:
                return new UserPatientResource($concrete);
            case Doctor::class:
                return new UserDoctorResource($concrete);
            case Nurse::class:
                return new UserNurseResource($concrete);
        }
    }
);

Route::prefix('auth')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::post('log-in', [
            Authentication\LogInController::class, 'create'
        ]);
        Route::post('join', [
            Authentication\JoinController::class, 'create'
        ]);
    });
    Route::middleware('auth')->group(function () {
        Route::delete('log-out', [
            Authentication\LogInController::class, 'destroy'
        ]);
    });
});

Route::controller(PatientController::class)->group(
    function () {
        Route::get('/patients', 'index');
        Route::get('/patients/{patient}', 'show');
        Route::get('/patients/{patient}/case-records', 'indexCaseRecords');
        Route::post('/patients/{patient}/case-records', 'storeCaseRecord');
        Route::get('/patients/{patient}/appointments', 'indexAppointments');
    }
);

Route::controller(DoctorController::class)->group(
    function () {
        Route::get('/doctors', 'index');
        Route::get('/doctors/{doctor}', 'show');
        Route::get('/doctors/{doctor}/patients', 'indexPatients');
        Route::get('/doctors/{doctor}/available-appointment-times', 'indexAvailableAppointmentTimes');
        Route::get('/doctors/{doctor}/appointments', 'indexAppointments');
    }
);

Route::controller(AppointmentController::class)
    ->middleware('auth')
    ->group(
        function () {
            Route::post('/doctors/{doctor}/appointments', 'store');
            Route::delete('/appointments/{appointment}', 'destroy');
            Route::patch('/appointments/{appointment}/confirm', 'confirm');
            
            Route::patch('/appointments/{appointment}/cancel', 'cancel');
            
            Route::patch('/appointments/{appointment}/success', 'success');
            Route::patch('/appointments/{appointment}/didnt-come', 'didntCome');
        }
    );

Route::controller(NewsController::class)->group(
    function () {
        Route::get('/news', 'index');
        Route::get('/news/{article}', 'show');
    }
);

Route::get('/about', function () {
    return [
        'data' => fake()->text(1000)
    ];
});

Route::controller(SpecialityController::class)->group(
    function () {
        Route::get('/specialities', 'index');
        Route::get('/specialities/{speciality}', 'show');
    }
);
