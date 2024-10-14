<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = User::where('email',$request->email)->first(['name', 'email', 'role', 'year', 'course','phone']);
        
        if ($user) {
            // Put the user data into session
            Session::put([
                'name'   => $user->name,
                'email'  => $user->email,
                'role'   => $user->role,
                'year'   => $user->year,
                'course' => $user->course,
                'phone'  => $user->phone
            ]);
        } else {
            // Handle the case where the user is not found
            Session::put([
                'name'   => null,
                'email'  => null,
                'role'   => null,
                'year'   => null,
                'course' => null,
                'phone'  => null
            ]);
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
