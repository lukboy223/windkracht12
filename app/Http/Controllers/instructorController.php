<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class instructorController extends Controller
{
    public function index()
    {
        return view('instructor.index');

    }

    public function create()
    {
        return view('instructor.create');
    }

    public function show($id)
    {
        return view('instructor.show', ['id' => $id]);
    }

    public function edit($id)
    {
        return view('instructor.edit', ['id' => $id]);
    }
    public function destroy($id)
    {
        // Logic to delete the instructor
        return redirect()->route('instructor.index')->with('success', 'Instructor deleted successfully.');
    }
}
