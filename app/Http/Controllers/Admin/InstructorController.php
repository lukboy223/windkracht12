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
use Illuminate\Validation\Rule;

class InstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $instructors = Instructor::with(['user', 'user.contact'])->get();
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
        // Validation and update logic would go here
        // For brevity, not implementing full update logic
        
        return redirect()->route('admin.instructors.index')
            ->with('success', 'Instructeur succesvol bijgewerkt.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Instructor $instructor)
    {
        // For brevity, not implementing full deletion logic
        // In a real application, you might want to soft delete or check for dependencies
        
        return redirect()->route('admin.instructors.index')
            ->with('success', 'Instructeur succesvol verwijderd.');
    }
}
