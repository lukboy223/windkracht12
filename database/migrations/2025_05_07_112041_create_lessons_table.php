<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id(); // Id (PK)
            $table->foreignId('registration_id')->constrained()->onDelete('cascade'); // Registration ID (FK)
            $table->foreignId('instructor_id')->constrained()->onDelete('cascade'); // Instructor ID (FK)
            $table->foreignId('car_id')->constrained()->onDelete('cascade'); // Car Id (FK)
            $table->date('start_date'); // Start date
            $table->time('start_time'); // Start time
            $table->date('end_date'); // End date
            $table->time('end_time'); // End time
            $table->enum('lesson_status', ['Planned', 'Completed', 'Canceled']); // Lesson status
            $table->text('goal')->nullable(); // Goal
            $table->text('student_comment')->nullable(); // Student Comment
            $table->text('commentary_instructor')->nullable(); // CommentaryInstructor
            $table->boolean('isactive')->default(true); // IsActive
            $table->text('remark')->nullable(); // Remark
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driving_lessons');
    }
};