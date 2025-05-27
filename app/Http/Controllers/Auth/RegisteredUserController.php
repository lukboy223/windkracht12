<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'infix' => ['nullable', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'birthdate' => ['required', 'date'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
        ]);

        // Generate a token for email verification
        $token = Str::random(60);

        // Build the name from firstname, infix and lastname
        $name = $request->firstname;
        if ($request->infix) {
            $name .= ' ' . $request->infix;
        }
        $name .= ' ' . $request->lastname;

        $user = User::create([
            'firstname' => $request->firstname,
            'infix' => $request->infix,
            'lastname' => $request->lastname,
            'birthdate' => $request->birthdate,
            'name' => $name,
            'email' => $request->email,
            'password' => Hash::make(Str::random(20)), // Temporary random password
            'is_active' => false, // User is inactive until verified
            'activation_token' => $token,
        ]);

        event(new Registered($user));

        // Send activation email with token
        $user->sendActivationEmail($token);

        return redirect()->route('register.confirmation');
    }

    /**
     * Display registration confirmation page.
     */
    public function confirmation(): View
    {
        return view('auth.register-confirmation');
    }

    /**
     * Show password creation form.
     */
    public function showSetPasswordForm(string $token): View
    {
        return view('auth.set-password', ['token' => $token]);
    }

    /**
     * Set user password and activate account.
     */
    public function setPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required', 'string'],
            'password' => [
                'required', 
                'confirmed', 
                'min:12',
                'regex:/[A-Z]/', // At least one uppercase letter
                'regex:/[0-9]/', // At least one number
                'regex:/[^A-Za-z0-9]/', // At least one special character
            ],
        ]);

        $user = User::where('activation_token', $request->token)->first();

        if (!$user) {
            return redirect()->route('register')
                ->withErrors(['email' => 'Invalid activation token.']);
        }

        $user->password = Hash::make($request->password);
        $user->is_active = true;
        $user->activation_token = null;
        $user->email_verified_at = now();
        $user->save();

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
