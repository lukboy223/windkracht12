<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // Add this line

class StudentController extends Controller
{
    use AuthorizesRequests; // Add this line

    public function index()
    {
        // Both administrators and instructors can see all students
        if (Auth::user()->hasRole(['administrator', 'instructor'])) {
            $students = Student::with('user')->get();
        } else {
            // Optionally restrict for other roles
            $students = Student::with('user')->where('user_id', Auth::id())->get();
        }
        return view('students.index', compact('students'));
    }

    public function create()
    {
        // No need to fetch users, just show the form
        return view('students.create');
    }

    public function store(Request $request)
    {
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

        return redirect()->route('students.index')->with('success', 'Student created.');
    }

    public function show(Student $student)
    {
        // Optionally check if the instructor owns this student
        $this->authorize('view', $student);
        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        // Both administrators and instructors can edit all students
        $this->authorize('update', $student);
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'Student')->where('isactive', true);
        })->get();
        return view('students.edit', compact('student', 'users'));
    }

    public function update(Request $request, Student $student)
    {
        $this->authorize('update', $student);
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
        return redirect()->route('students.index')->with('success', 'Student updated.');
    }

    public function destroy(Student $student)
    {
        $this->authorize('delete', $student);
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted.');
    }
}
