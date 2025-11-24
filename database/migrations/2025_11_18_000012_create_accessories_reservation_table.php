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
        Schema::create('accessories_reservation', function (Blueprint $table) {
            $table->integer('accessory_reservation_id')->primary();
            $table->dateTime('date_from')->nullable();
            $table->dateTime('date_to')->nullable();
            $table->dateTime('creation_date')->nullable();
            $table->integer('session_id');
            $table->integer('room_id');
            
            $table->index('session_id', 'fk_Inventory_reservations_Session1_idx');
            $table->index('room_id', 'fk_accessories_reservation_rooms1_idx');
            
            $table->foreign('session_id')
                ->references('gym_session_id')
                ->on('gym_sessions');
                
            $table->foreign('room_id')
                ->references('room_id')
                ->on('rooms');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accessories_reservation');
    }
};
