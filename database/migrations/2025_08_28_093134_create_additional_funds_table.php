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
        Schema::create('additional_funds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('added_by'); // who added the fund
            $table->decimal('amount', 15, 2);       // additional fund amount
            $table->date('release_date');           // fund release date
            $table->text('note')->nullable();
            $table->timestamps();

            $table->foreign('added_by')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('additional_funds');
    }
};
