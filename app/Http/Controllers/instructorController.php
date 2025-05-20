<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstructorController extends Controller
{
    public function index()
    {
        return view('instructor.index');
    }

    public function create()
    {
        return view('instructor.create');
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

        // Delete the notification about filling in BSN
        \App\Models\Notification::where('user_id', $instructor->user_id)
            ->where('type', 'Account Change')
            ->where('message', 'like', '%fill in your BSN%')
            ->delete();

        return redirect()->route('dashboard')->with('success', 'BSN opgeslagen.');
    }
}
