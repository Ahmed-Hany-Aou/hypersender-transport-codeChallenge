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
        Schema::create('promos', function (Blueprint $table) {
        $table->id();
        $table->string('code')->unique();            // Promo code
        $table->decimal('discount', 5, 2)->default(0); // Discount percentage/amount
        $table->date('valid_from')->nullable();      // When promo starts
        $table->date('valid_until')->nullable();     // When promo expires
        $table->boolean('active')->default(true);    // Enable/disable promo
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promos');
    }
};
