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
            $table->id();

            $table->float('amount_paid', 8, 2);
            
            $table->date('payment_date');
            $table->integer('payment_status_id');


            $table->string('gateway_transaction_id')->nullable();
            $table->string('gateway_preference_id')->nullable();
            $table->string('gateway_status_detail')->nullable();


            // Claves foráneas
            $table->foreignId('installment_id')->constrained()->onDelete('cascade');
            $table->foreignId('payment_method_id')->constrained()->onDelete('cascade');
            

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
