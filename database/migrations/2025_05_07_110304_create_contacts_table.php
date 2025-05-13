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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id(); // Id (PK)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // UserId (FK)
            $table->string('street_name'); // Street name
            $table->string('house_number'); // House number
            $table->string('addition')->nullable(); // Addition
            $table->string('postal_code'); // Postcode
            $table->string('place'); // Place
            $table->string('mobile')->nullable(); // Mobile
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
        Schema::dropIfExists('contacts');
    }
};