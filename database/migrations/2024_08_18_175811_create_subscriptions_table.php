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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name'); 
            $table->string('customer_email'); 
            $table->string('customer_phone')->nullable();
            $table->string('customer_address')->nullable(); 
            $table->date('start_date'); 
            $table->date('end_date');
            $table->enum('status', ['active', 'suspended', 'expired'])->default('active'); 
            $table->text('suspension_reason')->nullable(); 
            $table->enum('subscription_duration', ['monthly', '3_months', '6_months', '1_year'])->default('monthly');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
