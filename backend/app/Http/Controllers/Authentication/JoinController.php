<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JoinController extends Controller
{
    function create(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'username' => ['required', 'unique:users'],
            'firstName' => ['required'],
            'lastName' => ['required'],
            'gender' => ['required', 'in:male,female'],
            'password' => ['required'],
        ]);

        $user = User::make(
            [
                'email' => $request->email,
                'username' => $request->username,
                'first_name' => $request->firstName,
                'last_name' => $request->lastName,
                'gender' => $request->gender,
                'password' => Hash::make($request->password),
            ]
        );

        $patient = Patient::create([
            'birthdate' => fake()->dateTimeBetween('-80 years', '-18 years'),
        ]);

        $user->concrete()->associate($patient);
        $user->save();

        return response('Successfully joined', 200);
    }
}
