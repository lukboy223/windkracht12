<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Student;
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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
        ]);

        // Generate a token for email verification
        $token = Str::random(60);

        // Create a minimal user record with just the email
        $user = User::create([
            'email' => $request->email,
            'name' => '',
            'firstname' => '',
            'lastname' => '',
            'birthdate' => now(), // Temporary placeholder
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
     * Show complete registration form with user info and password fields.
     */
    public function showCompleteForm(string $token, Request $request): View
    {
        $email = $request->email;
        return view('auth.complete-registration', compact('token', 'email'));
    }

    /**
     * Complete the registration by updating user info and setting password.
     */
    public function completeRegistration(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'firstname' => ['required', 'string', 'max:255'],
            'infix' => ['nullable', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'birthdate' => ['required', 'date'],
            'street_name' => ['nullable', 'string', 'max:255'],
            'house_number' => ['nullable', 'string', 'max:20'],
            'addition' => ['nullable', 'string', 'max:20'],
            'postal_code' => [
                'nullable',
                'string',
                'min:6',
                'max:7',
                'regex:/^[1-9][0-9]{3}\s?[a-zA-Z]{2}$/', // Dutch postal code format (e.g., 1234 AB or 1234AB)
            ],
            'place' => ['nullable', 'string', 'max:255'],
            'mobile' => ['nullable', 'string', 'max:20'],
            'password' => [
                'required', 
                'confirmed', 
                'min:12',
                'regex:/[A-Z]/', // At least one uppercase letter
                'regex:/[0-9]/', // At least one number
                'regex:/[^\w]/', // At least one special character
            ],
        ], [
            'password.regex' => 'Het wachtwoord moet minimaal één hoofdletter, één cijfer en één speciaal teken bevatten.',
            'postal_code.regex' => 'De postcode moet bestaan uit 4 cijfers gevolgd door 2 letters (bijv. 1234 AB).',
        ]);

        $user = User::where('activation_token', $request->token)
                    ->where('email', $request->email)
                    ->first();

        if (!$user) {
            return redirect()->route('register')
                ->withErrors(['email' => 'Ongeldige activatietoken of e-mailadres.']);
        }

        // Build the full name
        $name = $request->firstname;
        if ($request->infix) {
            $name .= ' ' . $request->infix;
        }
        $name .= ' ' . $request->lastname;

        // Update the user with all the required information
        $user->firstname = $request->firstname;
        $user->infix = $request->infix;
        $user->lastname = $request->lastname;
        $user->name = $name;
        $user->birthdate = $request->birthdate;
        $user->password = Hash::make($request->password);
        $user->is_active = true;
        $user->activation_token = null;
        $user->email_verified_at = now();
        $user->save();

        // Automatically create a student record for the new user
        $student = new \App\Models\Student([
            'user_id' => $user->id,
            'relation_number' => 'S' . str_pad($user->id, 5, '0', STR_PAD_LEFT),
            'isactive' => true,
        ]);
        $student->save();

        // Create a role for the user
        \App\Models\Role::create([
            'user_id' => $user->id,
            'name' => 'Student',
            'isactive' => true,
        ]);

        // Create or update contact information
        \App\Models\Contact::updateOrCreate(
            ['user_id' => $user->id],
            [
                'street_name' => $request->street_name,
                'house_number' => $request->house_number,
                'addition' => $request->addition,
                'postal_code' => $request->postal_code,
                'place' => $request->place,
                'mobile' => $request->mobile,
                'isactive' => true,
            ]
        );

        // Log the user in
        Auth::login($user);

        return redirect()->route('dashboard')
            ->with('success', 'Registratie voltooid! Je bent nu ingelogd.');
    }
}
