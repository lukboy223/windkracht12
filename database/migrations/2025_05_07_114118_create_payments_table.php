
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
        Schema::create('payments', function (Blueprint $table) {
            $table->id(); // Id (PK)
            $table->foreignId('invoice_id')->constrained()->onDelete('cascade'); // InvoiceId (FK)
            $table->date('date'); // Date
            $table->enum('status', ['Pending', 'Completed', 'Failed', 'Refunded']); // Status
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
        Schema::dropIfExists('payments');
    }
};