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
            $table->dropColumn('experience_years');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_instruments', function (Blueprint $table) {
            $table->integer('experience_years')->default(0)->after('instrument_id');
        });
    }
};
