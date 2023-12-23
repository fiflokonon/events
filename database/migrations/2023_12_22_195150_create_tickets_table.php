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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('key')->nullable();
            $table->string('name')->nullable();
            $table->string('contact')->nullable();
            $table->enum('type_table', ['PASS_SIMPLE', 'SALON_SILVER', 'SALON_PLATINUM', 'SALON_GOLD', 'SALON_VIP']);
            $table->string('link')->nullable();
            $table->json('payment_details')->nullable();
            $table->boolean('scanned')->default(false);
            $table->boolean('downloaded')->default(false);
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
