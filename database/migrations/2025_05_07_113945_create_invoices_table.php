
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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id(); // Id (PK)
            $table->foreignId('registration_id')->constrained()->onDelete('cascade'); // Registration ID (FK)
            $table->string('invoice_number')->unique(); // Invoice number
            $table->date('invoice_date'); // Invoice date
            $table->decimal('amount_excl_vat', 10, 2); // AmountExcl.VAT
            $table->decimal('btw', 10, 2); // BTW (VAT)
            $table->decimal('amount_inc_vat', 10, 2); // AmountIncVAT
            $table->enum('invoice_status', ['Unpaid', 'Paid', 'Overdue', 'Canceled']); // Invoice status
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
        Schema::dropIfExists('invoices');
    }
};