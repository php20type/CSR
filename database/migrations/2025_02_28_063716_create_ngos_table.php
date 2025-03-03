<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ngos', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Location/NGO/Aashram Name
            $table->string('team_responsible');
            $table->string('food_type');
            $table->integer('quantity');
            $table->decimal('cost_per_unit', 10, 2);
            $table->decimal('other_costs', 10, 2)->nullable();
            $table->decimal('total_cost', 10, 2);
            $table->string('payment_mode');
            $table->decimal('remaining_budget', 10, 2);
            $table->text('remarks')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // Approval System
            $table->json('approved_by')->nullable(); // Store which admins approved it
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ngos');
    }
};
