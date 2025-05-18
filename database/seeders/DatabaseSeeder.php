<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Student;
use App\Models\Instructor;
use App\Models\Registration;
use App\Models\Lesson;
use App\Models\Package;
use App\Models\Car;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create 5 instructors
        $instructors = collect();
        for ($i = 1; $i <= 5; $i++) {
            $user = User::factory()->create([
                'firstname' => "Instructor{$i}",
                'lastname' => "Lastname{$i}",
                'birthdate' => '1980-01-01',
                'name' => "Instructor {$i}",
                'email' => "instructor{$i}@example.com",
                'password' => Hash::make('password'),
            ]);
            Role::factory()->create([
                'user_id' => $user->id,
                'name' => 'Instructor',
            ]);
            $instructor = Instructor::factory()->create([
                'user_id' => $user->id,
            ]);
            $instructors->push($instructor);
        }

        // Create 5 students
        $students = collect();
        for ($i = 1; $i <= 5; $i++) {
            $user = User::factory()->create([
                'firstname' => "Student{$i}",
                'lastname' => "Lastname{$i}",
                'birthdate' => '2000-01-01',
                'name' => "Student {$i}",
                'email' => "student{$i}@example.com",
                'password' => Hash::make('password'),
            ]);
            Role::factory()->create([
                'user_id' => $user->id,
                'name' => 'Student',
            ]);
            $student = Student::factory()->create([
                'user_id' => $user->id,
            ]);
            $students->push($student);
        }

        // Create some packages and cars if not already present
        $package = Package::factory()->create();

        // For each student, create a registration and at least 10 lessons
        foreach ($students as $student) {
            $registration = Registration::factory()->create([
                'student_id' => $student->id,
                'package_id' => $package->id,
            ]);
            for ($j = 0; $j < 10; $j++) {
                $instructor = $instructors->random();
                Lesson::factory()->create([
                    'registration_id' => $registration->id,
                    'instructor_id' => $instructor->user_id,

                    'start_date' => fake()->dateTimeBetween('-1 week', '+1 week')->format('Y-m-d'),
                    'start_time' => fake()->time(),
                ]);
            }
        }

        // For each instructor, ensure they have at least 10 lessons (as instructor)
        foreach ($instructors as $instructor) {
            $count = Lesson::where('instructor_id', $instructor->user_id)->count();
            for ($j = $count; $j < 10; $j++) {
                // Assign to a random student's registration
                $student = $students->random();
                $registration = Registration::where('student_id', $student->id)->first();
                Lesson::factory()->create([
                    'registration_id' => $registration->id,
                    'instructor_id' => $instructor->user_id,
                    'start_date' => fake()->dateTimeBetween('-1 week', '+1 week')->format('Y-m-d'),
                    'start_time' => fake()->time(),
                ]);
            }
        }
    }
}