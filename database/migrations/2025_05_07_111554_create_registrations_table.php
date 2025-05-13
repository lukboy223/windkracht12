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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id(); // Id (PK)
            $table->foreignId('student_id')->constrained()->onDelete('cascade'); // Student ID (FK)
            $table->foreignId('package_id')->constrained()->onDelete('cascade'); // PackageId (FK)
            $table->date('start_date'); // Start date
            $table->date('end_date')->nullable(); // End date
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
        Schema::dropIfExists('registrations');
    }
};