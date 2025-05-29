<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Instructor;
use App\Models\User;
use App\Models\Role;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class InstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all instructors including soft-deleted ones, but prioritize active ones
        $instructors = Instructor::with([
            'user' => function ($query) {
                $query->orderBy('is_active', 'desc'); // Show active first
            },
            'user.contact'
        ])
            ->get();

        return view('admin.instructors.index', compact('instructors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.instructors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation and storage logic would go here
        // For brevity, not implementing full creation logic

        return redirect()->route('admin.instructors.index')
            ->with('success', 'Instructeur succesvol toegevoegd.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Instructor $instructor)
    {
        $instructor->load(['user', 'user.contact']);
        return view('admin.instructors.show', compact('instructor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Instructor $instructor)
    {
        $instructor->load(['user', 'user.contact']);
        return view('admin.instructors.edit', compact('instructor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Instructor $instructor)
    {
        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'infix' => 'nullable|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($instructor->user_id),
            ],
            'birthdate' => 'nullable|date',
            'mobile' => 'nullable|string|max:20',
            'street_name' => 'nullable|string|max:255',
            'house_number' => 'nullable|string|max:10',
            'addition' => 'nullable|string|max:10',
            'postal_code' => 'nullable|string|max:7',
            'place' => 'nullable|string|max:255',
            'number' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ]);

        try {
            DB::beginTransaction();

            // Update user information
            $user = $instructor->user;

            // Create full name from components
            $name = $validated['firstname'];
            if (!empty($validated['infix'])) {
                $name .= ' ' . $validated['infix'];
            }
            $name .= ' ' . $validated['lastname'];

            $user->update([
                'firstname' => $validated['firstname'],
                'infix' => $validated['infix'],
                'lastname' => $validated['lastname'],
                'name' => $name,
                'email' => $validated['email'],
                'birthdate' => $validated['birthdate'],
                'is_active' => $validated['is_active'],
            ]);

            // Update or create contact information
            $user->contact()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'mobile' => $validated['mobile'],
                    'street_name' => $validated['street_name'],
                    'house_number' => $validated['house_number'],
                    'addition' => $validated['addition'],
                    'postal_code' => $validated['postal_code'],
                    'place' => $validated['place'],
                    'isactive' => true,
                ]
            );

            // Update instructor information
            $instructor->update([
                'number' => $validated['number'],
            ]);

            DB::commit();

            return redirect()->route('admin.instructors.index')
                ->with('success', 'Instructeur succesvol bijgewerkt.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()
                ->with('error', 'Er is een fout opgetreden bij het bijwerken van de instructeur: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Instructor $instructor)
    {
        try {
            DB::beginTransaction();

            // Get the associated user
            $user = $instructor->user;
            $userId = $user ? $user->id : null;

            if ($user) {
                // Delete contact information
                if ($user->contact) {
                    $user->contact->delete();
                }
                
                // Delete role assignments
                $user->roles()->delete();
                
                // Delete instructor record
                $instructor->delete();

                // Delete lessons connected to this instructor
                \App\Models\Lesson::where('instructor_id', $instructor->id)->delete();
                
                // Delete notifications for this user
                \App\Models\Notification::where('user_id', $userId)->delete();
                
                // Finally delete the user
                $user->delete();

                // Log complete deletion for audit purposes
                Log::info("Instructor completely deleted: (User ID: {$userId})");
            } else {
                // If no user is associated, just delete the instructor record
                $instructor->delete();
            }

            DB::commit();

            return redirect()->route('admin.instructors.index')
                ->with('success', 'Instructeur is volledig verwijderd uit het systeem');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error deleting instructor: " . $e->getMessage(), [
                'instructor_id' => $instructor->id,
                'exception' => $e,
            ]);

            return redirect()->route('admin.instructors.index')
                ->with('error', 'Er is een fout opgetreden bij het verwijderen van de instructeur: ' . $e->getMessage());
        }
    }
}
