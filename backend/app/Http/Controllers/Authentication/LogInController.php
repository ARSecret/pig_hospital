<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LogInController extends Controller
{
    public function create(Request $request)
    {
        $credentials = $request->validate(
            [
                'username' => ['required'],
                'password' => ['required'],
            ]
        );

        Log::debug('Log in attempt from ip {ip}', [
            'ip' => $request->ip(),
        ]);

        $throttleKey = Str::transliterate(
            Str::lower($request->username . '|' . $request->ip())
        );

        if (!Auth::attempt($credentials)) {
            Log::notice('Invalid credentials provided from ip {ip}: username = "{username}", password = "{password}"', [
                'ip' => $request->ip(),
                'username' => $credentials['username'],
                'password' => $credentials['password'],
            ]);
            return response([
                'email' => trans('auth.failed'),
            ], 403);
        }

        Log::info('User {username} successfully logged in from ip {ip}', [
            'username' => $credentials['username'],
            'ip' => $request->ip(),
        ]);
        $request->session()->regenerate();
        return response('login successful', 200);
    }

    public function destroy(Request $request)
    {
        if (!$request->user()) {
            abort(403);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response(null, 200);
    }
}
