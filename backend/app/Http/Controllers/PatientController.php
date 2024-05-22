<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

use App\Models\Patient;
use App\Http\Resources\UserPatientResource;
use App\Http\Resources\AppointmentResource;
use App\Http\Resources\CaseRecordResource;
use App\Models\CaseRecord;
use DateTime;

class PatientController extends Controller
{
    public function show(Patient $patient) {
        $this->authorize('view', $patient);

        return new UserPatientResource($patient);
    }
    
    public function index()
    {
        Gate::authorize('view-all-patients');

        return DB::table('patients')
            ->join('users', 'users.id', '=', 'patients.user_id')
            ->get();
    }

    public function indexAppointments(Patient $patient, Request $request)
    {
        $this->authorize('viewAppointments', $patient);

        $request->validate(
            [
                'date' => ['required', 'date'],
                'status' => [Rule::in(['created', 'confirmed', 'cancelled', 'successful', 'didnt-come'])]
            ]
        );

        $appointments = $patient->appointments()->whereDate('date_time', $request->date)->get()->sortBy('date_time');
        if ($request->status) {
            $appointments = $appointments->where('status', $request->status);
        }
        return AppointmentResource::collection($appointments);
    }

    public function indexCaseRecords(Request $request, Patient $patient) {
        $this->authorize('viewCaseRecords', $patient);

        return CaseRecordResource::collection($patient->case_records->sortBy('date_time', descending: true));
    }

    public function storeCaseRecord(Request $request, Patient $patient) {
        $this->authorize('createCaseRecord', $patient);
        
        $request->validate([
            'text' => ['required', 'string']
        ]);

        $caseRecord = new CaseRecord;
        $caseRecord->doctor()->associate($request->user()->concrete);
        $caseRecord->patient()->associate($patient);
        $caseRecord->date_time = new DateTime('now');
        $caseRecord->text = $request->text;
        $caseRecord->save();

        return response('Successfully created case record', 200);
    }
}
