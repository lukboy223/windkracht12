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
        // Create a dummy admin user
        $adminUser = User::factory()->create([
            'firstname' => 'Admin',
            'lastname' => 'User',
            'birthdate' => '1970-01-01',
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        Role::factory()->create([
            'user_id' => $adminUser->id,
            'name' => 'Administrator',
        ]);
        Contact::create([
            'user_id' => $adminUser->id,
            'street_name' => 'Admin Street',
            'house_number' => '1',
            'addition' => null,
            'postal_code' => '1234AB',
            'place' => 'Admintown',
            'mobile' => '0612345678',
            'isactive' => true,
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
        // Don't create packages as they are now defined in the migration
        $packages = Package::all(); // Get all predefined packages
        
        // Create some bookings and then link them to registrations
        $bookings = [];
        foreach ($students as $index => $student) {
            // Create 2 bookings per student
            for ($i = 0; $i < 2; $i++) {
                $package = $packages->random();
                $booking = \App\Models\Booking::create([
                    'user_id' => $student->user_id,
                    'package_id' => $package->id,
                    'booking_date' => fake()->dateTimeBetween('+1 day', '+30 days')->format('Y-m-d'),
                    'booking_time' => fake()->randomElement(['morning', 'afternoon']),
                    'participants' => fake()->numberBetween(1, 2),
                    'partner_name' => fake()->boolean(30) ? fake()->name() : null,
                    'notes' => fake()->boolean(50) ? fake()->sentence() : null,
                    'status' => fake()->randomElement(['pending', 'confirmed', 'completed', 'canceled']),
                    'isactive' => true,
                ]);
                $bookings[] = $booking;
            }
        }

        // For each student, create a registration linked to bookings
        foreach ($students as $student) {
            // Get a random booking belonging to this student
            $booking = \App\Models\Booking::where('user_id', $student->user_id)->first();
            
            if ($booking) {
                $registration = Registration::factory()->create([
                    'student_id' => $student->id,
                    'package_id' => $booking->package_id,
                    'booking_id' => $booking->id,
                    'start_date' => $booking->booking_date,
                ]);
                
                // Create lessons only for confirmed bookings
                if ($booking->status === 'confirmed') {
                    for ($j = 0; $j < 5; $j++) {
                        $instructor = $instructors->random();
                        Lesson::factory()->create([
                            'registration_id' => $registration->id,
                            'lesson_status' => fake()->randomElement(['Planned', 'Completed', 'Canceled']),
                            'number_of_students' => $booking->participants,
                            'instructor_id' => $instructor->user_id,
                            'start_date' => fake()->dateTimeBetween($booking->booking_date, '+2 weeks')->format('Y-m-d'),
                            'start_time' => $booking->booking_time === 'morning' ? 
                                fake()->dateTimeBetween('09:00', '12:00')->format('H:i:s') : 
                                fake()->dateTimeBetween('13:00', '16:00')->format('H:i:s'),
                        ]);
                    }
                }
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