<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->string('id')->primary(); // 'private', 'duo-single', etc.
            $table->string('name');
            $table->string('duration');
            $table->decimal('price', 8, 2);
            $table->text('description');
            $table->json('features'); // Store features as JSON
            $table->boolean('isactive')->default(true);
            $table->timestamps();
        });

        // Insert predefined packages
        DB::table('packages')->insert([
            [
                'id' => 'private',
                'name' => 'Privéles',
                'duration' => '2.5 uur',
                'price' => 175.00,
                'description' => 'Een privé kitesurfles speciaal voor jou',
                'features' => json_encode(['inclusief alle materialen', 'Eén persoon']),
                'isactive' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'duo-single',
                'name' => '1 dagdeel Losse Duo Kiteles',
                'duration' => '3.5 uur',
                'price' => 135.00,
                'description' => 'Eén kitesurfles voor jou en een partner',
                'features' => json_encode(['inclusief alle materialen', 'Max 2 personen']),
                'isactive' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'duo-three',
                'name' => '3 dagdelen Duo Kiteles',
                'duration' => '10.5 uur',
                'price' => 375.00,
                'description' => 'Serie van 3 kitesurflessen voor jou en een partner',
                'features' => json_encode(['inclusief alle materialen', 'Max 2 personen', '3 dagdelen']),
                'isactive' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'duo-five',
                'name' => '5 dagdelen Duo Kiteles',
                'duration' => '17.5 uur',
                'price' => 675.00,
                'description' => 'Complete serie van 5 kitesurflessen voor jou en een partner',
                'features' => json_encode(['inclusief alle materialen', 'Max 2 personen', '5 dagdelen']),
                'isactive' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
