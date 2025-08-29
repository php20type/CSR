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
        Schema::table('ngos', function (Blueprint $table) {
            $table->unsignedBigInteger('released_by')->nullable()->after('approved_by');
            $table->foreign('released_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ngos', function (Blueprint $table) {
            $table->dropColumn('released_by');
        });
    }
};
