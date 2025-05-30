<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use App\Models\User;
use App\Models\Role;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class InstructorController extends Controller
{
    public function __construct()
    {
        // Only allow administrators to access these methods
        $this->middleware(function ($request, $next) {
            if (!auth()->user() || !auth()->user()->roles()->where('name', 'Administrator')->where('isactive', true)->exists()) {
                abort(403, 'Unauthorized action.');
            }
            return $next($request);
        })->except(['showBsnForm', 'saveBsn']);
    }
    
    public function index()
    {
        $instructors = Instructor::with('user')->get();
        return view('instructors.index', compact('instructors'));
    }

    public function create()
    {
        return view('instructors.create');
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $validated = $request->validate([
                'firstname' => 'required|string|max:255',
                'infix' => 'nullable|string|max:255',
                'lastname' => 'required|string|max:255',
                'birthdate' => 'required|date',
                'email' => 'required|string|email|max:255|unique:users,email',
                'password' => 'required|string|min:8',
                'number' => 'required|string|max:255|unique:instructors,number',
                'bsn' => 'nullable|string|max:255',
                'isactive' => 'boolean',
                'street_name' => 'nullable|string|max:255',
                'house_number' => 'nullable|string|max:255',
                'addition' => 'nullable|string|max:255',
                'postal_code' => 'nullable|string|max:255',
                'place' => 'nullable|string|max:255',
                'mobile' => 'nullable|string|max:255',
            ]);
            
            // Build full name
            $name = $validated['firstname'];
            if (!empty($validated['infix'])) {
                $name .= ' ' . $validated['infix'];
            }
            $name .= ' ' . $validated['lastname'];
            
            // Create user
            $user = User::create([
                'firstname' => $validated['firstname'],
                'infix' => $validated['infix'],
                'lastname' => $validated['lastname'],
                'birthdate' => $validated['birthdate'],
                'name' => $name,
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'is_active' => $validated['isactive'] ?? true,
            ]);
            
            // Create instructor
            $instructor = Instructor::create([
                'user_id' => $user->id,
                'number' => $validated['number'],
                'bsn' => $validated['bsn'],
                'isactive' => $validated['isactive'] ?? true,
            ]);
            
            // Create role
            Role::create([
                'user_id' => $user->id,
                'name' => 'Instructor',
                'isactive' => true,
            ]);
            
            // Create contact
            Contact::create([
                'user_id' => $user->id,
                'street_name' => $validated['street_name'],
                'house_number' => $validated['house_number'],
                'addition' => $validated['addition'],
                'postal_code' => $validated['postal_code'],
                'place' => $validated['place'],
                'mobile' => $validated['mobile'],
                'isactive' => true,
            ]);
            
            DB::commit();
            
            return redirect()->route('instructors.index')
                ->with('success', 'Instructeur succesvol aangemaakt.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating instructor: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Fout bij het aanmaken van instructeur: ' . $e->getMessage());
        }
    }

    public function show(Instructor $instructor)
    {
        return view('instructors.show', compact('instructor'));
    }

    public function edit(Instructor $instructor)
    {
        return view('instructors.edit', compact('instructor'));
    }

    public function update(Request $request, Instructor $instructor)
    {
        try {
            DB::beginTransaction();
            
            $validated = $request->validate([
                'firstname' => 'required|string|max:255',
                'infix' => 'nullable|string|max:255',
                'lastname' => 'required|string|max:255',
                'birthdate' => 'required|date',
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('users')->ignore($instructor->user_id),
                ],
                'password' => 'nullable|string|min:8',
                'number' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('instructors', 'number')->ignore($instructor->id),
                ],
                'bsn' => 'nullable|string|max:255',
                'isactive' => 'boolean',
                'street_name' => 'nullable|string|max:255',
                'house_number' => 'nullable|string|max:255',
                'addition' => 'nullable|string|max:255',
                'postal_code' => 'nullable|string|max:255',
                'place' => 'nullable|string|max:255',
                'mobile' => 'nullable|string|max:255',
            ]);
            
            // Update instructor
            $instructor->number = $validated['number'];
            $instructor->bsn = $validated['bsn'];
            $instructor->isactive = $validated['isactive'] ?? true;
            $instructor->save();
            
            // Update user
            $user = $instructor->user;
            if ($user) {
                // Build full name
                $name = $validated['firstname'];
                if (!empty($validated['infix'])) {
                    $name .= ' ' . $validated['infix'];
                }
                $name .= ' ' . $validated['lastname'];
                
                $user->firstname = $validated['firstname'];
                $user->infix = $validated['infix'];
                $user->lastname = $validated['lastname'];
                $user->birthdate = $validated['birthdate'];
                $user->name = $name;
                $user->email = $validated['email'];
                
                if (!empty($validated['password'])) {
                    $user->password = Hash::make($validated['password']);
                }
                
                $user->is_active = $validated['isactive'] ?? true;
                $user->save();
                
                // Update contact
                $contact = $user->contact ?? new Contact(['user_id' => $user->id]);
                $contact->street_name = $validated['street_name'];
                $contact->house_number = $validated['house_number'];
                $contact->addition = $validated['addition'];
                $contact->postal_code = $validated['postal_code'];
                $contact->place = $validated['place'];
                $contact->mobile = $validated['mobile'];
                $contact->isactive = true;
                $contact->save();
            }
            
            DB::commit();
            
            return redirect()->route('instructors.index')
                ->with('success', 'Instructeur succesvol bijgewerkt.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating instructor: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Fout bij het bijwerken van instructeur: ' . $e->getMessage());
        }
    }

    public function destroy(Instructor $instructor)
    {
        try {
            DB::beginTransaction();
            
            // Make the instructor inactive instead of deleting
            $instructor->isactive = false;
            $instructor->save();
            
            // Also make the user role inactive
            if ($instructor->user) {
                $role = $instructor->user->roles()->where('name', 'Instructor')->first();
                if ($role) {
                    $role->isactive = false;
                    $role->save();
                }
            }
            
            DB::commit();
            
            return redirect()->route('instructors.index')
                ->with('success', 'Instructeur succesvol verwijderd.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting instructor: ' . $e->getMessage());
            return back()
                ->with('error', 'Fout bij het verwijderen van instructeur: ' . $e->getMessage());
        }
    }

    // Existing BSN methods
    public function showBsnForm($id)
    {
        $instructor = Instructor::findOrFail($id);
        // Only allow the instructor to edit their own BSN
        if (auth()->id() !== $instructor->user_id) {
            abort(403, 'Je mag deze BSN niet aanpassen.');
        }
        return view('instructors.bsn', compact('instructor'));
    }

    public function saveBsn(Request $request, $id)
    {
        $instructor = Instructor::findOrFail($id);
        // Only allow the instructor to edit their own BSN
        if (auth()->id() !== $instructor->user_id) {
            abort(403, 'Je mag deze BSN niet aanpassen.');
        }
        $request->validate([
            'bsn' => 'required|string|max:255',
        ]);
        $instructor->bsn = $request->input('bsn');
        $instructor->save();

        return redirect()->route('dashboard')->with('success', 'BSN opgeslagen.');
    }
}
