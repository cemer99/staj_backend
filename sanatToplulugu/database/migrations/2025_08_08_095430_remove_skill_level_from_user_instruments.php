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
        Schema::table('user_instruments', function (Blueprint $table) {
            $table->dropColumn('skill_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_instruments', function (Blueprint $table) {
            $table->enum('skill_level', ['beginner', 'intermediate', 'advanced', 'professional'])->default('beginner')->after('instrument_id');
        });
    }
};
