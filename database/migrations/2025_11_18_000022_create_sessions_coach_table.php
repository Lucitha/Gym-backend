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
        Schema::create('sessions_coach', function (Blueprint $table) {
            $table->integer('session_coach_id')->primary();
            $table->integer('user_id');
            $table->integer('session_id');
            $table->tinyInteger('active_flag')->nullable();
            
            $table->index('user_id', 'fk_Sessions_coach_Users1_idx');
            $table->index('session_id', 'fk_Sessions_coach_Sessions1_idx');
            
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
                
            $table->foreign('session_id')
                ->references('gym_session_id')
                ->on('gym_sessions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions_coach');
    }
};
