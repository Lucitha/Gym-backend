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
        Schema::create('inventory_trackings', function (Blueprint $table) {
            $table->integer('invetory_tracking_id')->primary();
            $table->date('entry_date')->nullable();
            $table->integer('room_id');
            $table->integer('inventory_id');
            
            $table->index('room_id', 'fk_room_inventory_rooms1_idx');
            $table->index('inventory_id', 'fk_room_inventory_Inventory1_idx');
            
            $table->foreign('room_id')
                ->references('room_id')
                ->on('rooms');
                
            $table->foreign('inventory_id')
                ->references('inventory_id')
                ->on('inventory');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_trackings');
    }
};
