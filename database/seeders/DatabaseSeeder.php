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
use App\Models\Contact;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create 3 users
        $users = User::factory()->count(3)->create();

        // Assign roles and contacts
        foreach ($users as $index => $user) {
            // Assign roles
            $roleName = match ($index) {
                0 => 'Administrator',
                1 => 'Instructor',
                default => 'Student',
            };
            Role::create([
                'user_id' => $user->id,
                'name' => $roleName,
                'isactive' => true,
            ]);
            // Add contact
            Contact::create([
                'user_id' => $user->id,
                'street_name' => 'Main Street',
                'house_number' => (string)(100 + $index),
                'addition' => null,
                'postal_code' => '1234AB',
                'place' => 'Cityville',
                'mobile' => '061234567' . $index,
                'isactive' => true,
            ]);
        }

        // Create students for user 3 (student)
        Student::create([
            'user_id' => $users[2]->id,
            'relation_number' => 'REL123',
            'isactive' => true,
            'remark' => 'Dummy student',
        ]);

        // Create 5 instructors
        $instructors = collect();
        for ($i = 1; $i <= 5; $i++) {
            $user = User::factory()->create([
                'firstname' => "John{$i}",
                'lastname' => "Doe{$i}",
                'birthdate' => '1980-01-01',
                'name' => "Instructor {$i}",
                'email' => "instructor{$i}@example.com",
                'password' => Hash::make('password'),
            ]);
            Role::factory()->create([
                'user_id' => $user->id,
                'name' => 'Instructor',
            ]);
            Contact::create([
                'user_id' => $user->id,
                'street_name' => "Instructor Street {$i}",
                'house_number' => (string)(200 + $i),
                'addition' => null,
                'postal_code' => '5678CD',
                'place' => 'Instructortown',
                'mobile' => '068765432' . $i,
                'isactive' => true,
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
                'firstname' => "John{$i}",
                'lastname' => "Pork{$i}",
                'birthdate' => '2000-01-01',
                'name' => "Student {$i}",
                'email' => "student{$i}@example.com",
                'password' => Hash::make('password'),
            ]);
            Role::factory()->create([
                'user_id' => $user->id,
                'name' => 'Student',
            ]);
            Contact::create([
                'user_id' => $user->id,
                'street_name' => "Student Lane {$i}",
                'house_number' => (string)(300 + $i),
                'addition' => null,
                'postal_code' => '9012EF',
                'place' => 'Studentcity',
                'mobile' => '067890123' . $i,
                'isactive' => true,
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