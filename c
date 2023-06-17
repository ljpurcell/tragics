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
        Schema::create('user_match_days', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('match_day_id');
            $table->unsignedSmallInteger('user_id');
            $table->json('rules_array');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_match_days');
    }
};
