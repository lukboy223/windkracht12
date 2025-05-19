<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Student;

class StudentPolicy
{
    public function view(User $user, Student $student)
    {
        return $this->canAccess($user, $student);
    }

    public function update(User $user, Student $student)
    {
        return $this->canAccess($user, $student);
    }

    public function delete(User $user, Student $student)
    {
        return $this->canAccess($user, $student);
    }

    protected function canAccess(User $user, Student $student)
    {
        // Admins can access all
        if ($user->roles()->where('name', 'Administrator')->where('isactive', true)->exists()) {
            return true;
        }
        // Instructors can access students they teach (via lessons/registrations)
        if ($user->roles()->where('name', 'Instructor')->where('isactive', true)->exists()) {
            $lessonInstructorIds = \App\Models\Lesson::where('instructor_id', $user->id)
                ->pluck('registration_id');
            $studentIds = \App\Models\Registration::whereIn('id', $lessonInstructorIds)
                ->pluck('student_id');
            return $studentIds->contains($student->id);
        }
        return false;
    }
}
