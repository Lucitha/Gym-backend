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
        Schema::create('inventory_logs', function (Blueprint $table) {
            $table->integer('inventory_log_id')->primary();
            $table->tinyInteger('active_flag')->nullable();
            $table->date('action_date')->nullable();
            $table->string('description', 45)->nullable();
            $table->integer('inventory_id');
            $table->dateTime('creation_date')->nullable();
            
            $table->index('inventory_id', 'fk_Inventory_tracking_Inventory1_idx');
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
        Schema::dropIfExists('inventory_logs');
    }
};
