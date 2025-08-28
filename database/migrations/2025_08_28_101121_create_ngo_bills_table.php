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
        Schema::create('ngo_bills', function (Blueprint $table) {
            $table->id();
            // Relations
            $table->unsignedBigInteger('ngo_id');   // Link to NGO
            $table->unsignedBigInteger('user_id');  // Who uploaded bill

            // Bill fields
            $table->string('bill_number')->unique();
            $table->string('bill_file');  // path to bill file
            $table->decimal('amount', 12, 2)->default(0);

            $table->timestamps();

            // Foreign keys
            $table->foreign('ngo_id')->references('id')->on('ngos')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ngo_bills');
    }
};
