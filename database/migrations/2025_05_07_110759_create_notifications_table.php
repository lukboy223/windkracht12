php
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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id(); // Id (PK)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // UserId (FK)
            $table->enum('target_audience', ['Student', 'Instructor', 'Both']); // Target audience
            $table->text('message'); // Message
            $table->enum('type', [
                'Sick', 
                'Lesson Change', 
                'Lesson Cancellation', 
                'Lesson Pickup Address Change', 
                'Lesson Goal Change'
            ]); // Type Notification
            $table->dateTime('date'); // Date
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
        Schema::dropIfExists('notifications');
    }
};