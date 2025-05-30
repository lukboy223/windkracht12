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
        Schema::create('instructors', function (Blueprint $table) {
            $table->id(); // Id (PK)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // UserId (FK)
            $table->string('number'); // Number
            $table->string('BSN')->nullable(); // BSN
            $table->boolean('isactive')->default(true); // Isactive
            $table->text('remark')->nullable(); // Remark
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instructors');
    }
};