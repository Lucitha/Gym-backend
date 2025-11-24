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
        Schema::create('gym_sessions', function (Blueprint $table) {
            $table->integer('gym_session_id')->primary();
            $table->string('title', 45)->nullable();
            $table->integer('courses_id');
            $table->integer('max_subscription')->nullable();
            $table->integer('current_subscription')->nullable();
            $table->string('QR', 45)->nullable();
            
            $table->index('courses_id', 'fk_Session_Courses1_idx');
            $table->foreign('courses_id')
                ->references('courses_id')
                ->on('courses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gym_sessions');
    }
};
