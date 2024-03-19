<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

use App\Models\Speciality;
use App\Http\Resources\SpecialityResource;

class SpecialityController extends Controller
{
    public function index()
    {
        Gate::authorize('view-all-specialities');

        return SpecialityResource::collection(Speciality::all());
    }

    public function show(Speciality $speciality)
    {
        return new SpecialityResource($speciality);
    }
}
