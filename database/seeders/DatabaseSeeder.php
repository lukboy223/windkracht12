<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Contact;
use App\Models\Lesson;
use App\Models\Exam;
use App\Models\Instructor;
use App\Models\Invoice;
use App\Models\Notification;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Registration;
use App\Models\Role;
use App\Models\Student;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'firstname' => 'john',
            'lastname' => 'doe',
            'birthdate' => '1900-01-01',
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => encrypt('cookie123')
        ]);


        Lesson::factory(200)->create();

        Contact::factory(200)->create();

        Instructor::factory(200)->create();

        Invoice::factory(200)->create();

        Notification::factory(200)->create();

        Package::factory(200)->create();

        Payment::factory(200)->create();

        Registration::factory(200)->create();

        Role::factory(200)->create();

        Student::factory(200)->create();
    }
}
