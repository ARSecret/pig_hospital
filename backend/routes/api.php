<?php

use App\Http\Controllers\SpecialityController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\NewsController;
use App\Http\Resources\UserResource;

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

Route::middleware('auth:sanctum')->get(
    '/user',
    function (Request $request) {
        return new UserResource($request->user());
    }
);

Route::post(
    '/login',
    function (Request $request) {
        $credentials = $request->validate(
            [
                'login' => ['required'],
                'password' => ['required'],
            ]
        );

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return response('login successful', 200);
        }

        abort(403);
    }
);

Route::post(
    '/logout',
    function (Request $request) {
        if (!$request->user()) {
            abort(403);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response(null, 200);
    }
);

Route::controller(PatientController::class)->group(
    function () {
        Route::get('/patients', 'index');
        Route::get('/patients/{patient}', 'show');
        Route::get('/patients/{patient}/appointments', 'indexAppointments');
        Route::get('/patients/{patient}/case-records', 'indexCaseRecords');
        Route::post('/patients/{patient}/case-records', 'storeCaseRecord');
    }
);

Route::controller(DoctorController::class)->group(
    function () {
        Route::get('/doctors', 'index');
        Route::get('/doctors/{doctor}', 'show');
        Route::get('/doctors/{doctor}/patients', 'indexPatients');
        Route::get('/doctors/{doctor}/appointments', 'indexAppointments');
        Route::get('/doctors/{doctor}/available-appointments', 'indexAvailableAppointments');
        Route::post('/doctors/{doctor}/appointments', 'storeAppointment');
    }
);

Route::controller(AppointmentController::class)->group(
    function () {
        Route::delete('/appointments/{appointment}', 'destroy');
        Route::patch('/appointments/{appointment}/confirm', 'confirm');
    }
);

Route::controller(NewsController::class)->group(
    function () {
        Route::get('/news', 'index');
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
