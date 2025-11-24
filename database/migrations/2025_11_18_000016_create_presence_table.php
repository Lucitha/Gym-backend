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
        Schema::create('presence', function (Blueprint $table) {
            $table->integer('presence_id')->primary();
            $table->string('creation_date', 45)->nullable();
            $table->integer('registration_id');
            $table->string('comment', 45)->nullable();
            $table->integer('session_id');
            
            $table->index('registration_id', 'fk_Presence_Registrations1_idx');
            $table->index('session_id', 'fk_Presence_Sessions1_idx');
            
            $table->foreign('registration_id')
                ->references('registration_id')
                ->on('registrations');
                
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
        Schema::dropIfExists('presence');
    }
};
