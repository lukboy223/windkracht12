<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Update user information
        $request->user()->fill($request->validated());

        // Create full name from components
        $name = $request->validated('firstname');
        if (!empty($request->validated('infix'))) {
            $name .= ' ' . $request->validated('infix');
        }
        $name .= ' ' . $request->validated('lastname');
        
        $request->user()->name = $name;

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        // Update or create contact information
        $request->user()->contact()->updateOrCreate(
            ['user_id' => $request->user()->id],
            [
                'street_name' => $request->validated('street_name'),
                'house_number' => $request->validated('house_number'),
                'addition' => $request->validated('addition'),
                'postal_code' => $request->validated('postal_code'),
                'place' => $request->validated('place'),
                'mobile' => $request->validated('mobile'),
                'isactive' => true,
            ]
        );

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
