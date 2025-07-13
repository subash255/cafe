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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
                  $table->foreignId('user_id')
                  ->constrained()          // → users.id
                  ->cascadeOnDelete();     // delete orders if the user goes away

            $table->foreignId('fooditem_id')
                  ->constrained('fooditems') // → fooditems.id
                  ->cascadeOnDelete();
            $table->integer('amount');
            $table->string('status')->default('pending'); // Order status (e.g.,

             $table->string('paid_reference')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
