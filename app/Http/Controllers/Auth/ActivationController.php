<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ActivationController extends Controller
{
    //
    public function activate(Request $request, $token)
    {
        // Logic to activate the user account using the token
        // This is just a placeholder; actual implementation will depend on your application logic
        // For example, you might find the user by the token and set their 'active' status to true

        return redirect()->route('home')->with('success', 'Account activated successfully.');
    }

    public function resendActivationEmail(Request $request)
    {
        // Logic to resend activation email
        // This could involve finding the user by their email and dispatching a job to send the activation email

        return redirect()->back()->with('success', 'Activation email resent successfully.');
    }

    public function showForm($token)
    {
        // Get the activation token from the request
        Log::info("Activation token received: $token");
        $token = $token;

        return view('auth.activation', compact('token'));
    }

    public function submitForm(Request $request, $token)
    {
        // Logic to handle the form submission
        // This could involve validating the input and then calling the resendActivationEmail method

        $user = User::where('activation_token', $token)->firstOrFail();
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->is_active = true; // Activate the user
        $user->activation_token = null; // Clear the token after activation
        $user->save();

        Auth::login($user);
        Log::info("User activated successfully: {$user->email}");

        return redirect()->route('users')->with('success', 'Your credentials were set successfully.');
    }
}
