<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use App\Models\Notification;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // Add this line
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    use AuthorizesRequests; // Add this line

    public function index()
    {
        try {
            $students = Student::with('user')->get();
            return view('students.index', compact('students'));
        } catch (\Throwable $e) {
            Log::error('Error loading students: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Error loading students: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            return view('students.create');
        } catch (\Throwable $e) {
            Log::error('Error loading create form: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Error loading create form: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $validated = $request->validate([
                'user_firstname' => 'required|string|max:255',
                'user_lastname' => 'required|string|max:255',
                'user_birthdate' => 'required|date',
                'user_email' => 'required|email|unique:users,email',
                'user_password' => 'required|string|min:6',
                'relation_number' => 'required|string|max:255',
                'isactive' => 'boolean',
                'remark' => 'nullable|string',
                // Contact fields
                'contact_street_name' => 'nullable|string|max:255',
                'contact_house_number' => 'nullable|string|max:255',
                'contact_addition' => 'nullable|string|max:255',
                'contact_postal_code' => 'nullable|string|max:255',
                'contact_place' => 'nullable|string|max:255',
                'contact_mobile' => 'nullable|string|max:255',
            ]);

            // Create user
            $user = User::create([
                'firstname' => $validated['user_firstname'],
                'lastname' => $validated['user_lastname'],
                'birthdate' => $validated['user_birthdate'],
                'name' => $validated['user_firstname'] . ' ' . $validated['user_lastname'],
                'email' => $validated['user_email'],
                'password' => bcrypt($validated['user_password']),
            ]);

            // Assign Student role
            \App\Models\Role::create([
                'user_id' => $user->id,
                'name' => 'Student',
                'isactive' => true,
            ]);

            // Create contact
            \App\Models\Contact::create([
                'user_id' => $user->id,
                'street_name' => $validated['contact_street_name'] ?? null,
                'house_number' => $validated['contact_house_number'] ?? null,
                'addition' => $validated['contact_addition'] ?? null,
                'postal_code' => $validated['contact_postal_code'] ?? null,
                'place' => $validated['contact_place'] ?? null,
                'mobile' => $validated['contact_mobile'] ?? null,
                'isactive' => true,
            ]);

            // Create student
            Student::create([
                'user_id' => $user->id,
                'relation_number' => $validated['relation_number'],
                'isactive' => $validated['isactive'] ?? true,
                'remark' => $validated['remark'] ?? null,
            ]);

            DB::commit();
            return redirect()->route('students.index')->with('success', 'Student created.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error creating student: ' . $e->getMessage(), ['exception' => $e]);
            return back()->withInput()->with('error', 'Error creating student: ' . $e->getMessage());
        }
    }

    public function show(Student $student)
    {
        try {
            $this->authorize('view', $student);
            return view('students.show', compact('student'));
        } catch (\Throwable $e) {
            Log::error('Error loading student: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Error loading student: ' . $e->getMessage());
        }
    }

    public function edit(Student $student)
    {
        try {
            $users = User::whereHas('roles', function ($query) {
                $query->where('name', 'Student')->where('isactive', true);
            })->get();
            $roles = [
                'Student' => 'Student',
                'Instructor' => 'Instructor',
                'Administrator' => 'Administrator',
            ];
            return view('students.edit', compact('student', 'users', 'roles'));
        } catch (\Throwable $e) {
            Log::error('Error loading edit form: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Error loading edit form: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Student $student)
    {
        try {
            DB::beginTransaction();
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'relation_number' => 'required|string|max:255',
                'isactive' => 'boolean',
                'remark' => 'nullable|string',
                'user_name' => 'required|string|max:255',
                // Contact fields
                'contact_street_name' => 'nullable|string|max:255',
                'contact_house_number' => 'nullable|string|max:255',
                'contact_addition' => 'nullable|string|max:255',
                'contact_postal_code' => 'nullable|string|max:255',
                'contact_place' => 'nullable|string|max:255',
                'contact_mobile' => 'nullable|string|max:255',
            ]);
            $student->update([
                'user_id' => $validated['user_id'],
                'relation_number' => $validated['relation_number'],
                'isactive' => $validated['isactive'],
                'remark' => $validated['remark'],
            ]);
            // Update related user
            $user = $student->user;
            if ($user) {
                $user->name = $validated['user_name'];
                $user->save();
                // Update role if admin and role is present in request
                if (
                    $request->has('role') &&
                    auth()->user() &&
                    auth()->user()->roles()->where('name', 'Administrator')->where('isactive', true)->exists()
                ) {
                    $roleModel = $user->roles()->where('isactive', true)->first();
                    $oldRole = $roleModel ? $roleModel->name : null;
                    $newRole = $request->input('role');
                    if ($roleModel && $oldRole !== $newRole) {
                        // Move role update INSIDE the transaction, but only save if all succeeds
                        $roleModel->name = $newRole;
                        // Do NOT save yet

                        // If role changed from Student to something else (but NOT Instructor), remove student row
                        if (
                            $oldRole === 'Student'
                            && $newRole !== 'Student'
                            && $newRole !== 'Instructor'
                            && $student
                        ) {
                            $student->delete();
                        }
                        // If role changed to Instructor, create instructor row if not exists
                        if ($newRole === 'Instructor' && !$user->instructor) {
                            $Instructor = Instructor::create([
                                'user_id' => $user->id,
                                'number' => 'e' . ($user->id + 1000)
                            ]);
                            // Create notification in the database
                            Notification::create([
                                'type' => 'Account Change',
                                'user_id' => $user->id,
                                'message' => 'You have been assigned as an instructor. Please fill in your BSN number. <a href="' . url('/instructor/bsn/' . $Instructor->id) . '">Klik hier</a>',
                                'is_read' => false,
                                'date' => now(),
                            ]);
                            // Remove student row if present
                            if ($student) {
                                $student->delete();
                            }
                        }
                        // Now save the role change as the last step
                        $roleModel->save();
                    }
                }
                // Update contact table
                if ($user->contact) {
                    $user->contact->street_name = $validated['contact_street_name'];
                    $user->contact->house_number = $validated['contact_house_number'];
                    $user->contact->addition = $validated['contact_addition'];
                    $user->contact->postal_code = $validated['contact_postal_code'];
                    $user->contact->place = $validated['contact_place'];
                    $user->contact->mobile = $validated['contact_mobile'];
                    $user->contact->save();
                }
            }
            DB::commit();
            return redirect()->route('students.index')->with('success', 'Student updated.');
        } catch (\Throwable $e) {
            DB::rollBack();
            if ($newRole === 'Instructor') {
                $Instructor->delete();
            }
            Log::error('Error updating student: ' . $e->getMessage(), ['exception' => $e]);
            return back()->withInput()->with('error', 'Error updating student: ' . $e->getMessage());
        }
    }

    public function destroy(Student $student)
    {
        try {
            DB::beginTransaction();
            $student->delete();
            DB::commit();
            return redirect()->route('students.index')->with('success', 'Student deleted.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error deleting student: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Error deleting student: ' . $e->getMessage());
        }
    }
}
