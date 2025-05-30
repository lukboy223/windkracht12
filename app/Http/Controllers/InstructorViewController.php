<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use Illuminate\Http\Request;

class InstructorViewController extends Controller
{
    /**
     * Display instructor details for students
     * This is a simplified view with only public information
     */
    public function show(Instructor $instructor)
    {
        $instructor->load('user');
        
        return view('instructors.show', compact('instructor'));
    }
}
