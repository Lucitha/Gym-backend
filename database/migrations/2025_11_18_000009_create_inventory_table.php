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
        Schema::create('inventory', function (Blueprint $table) {
            $table->integer('inventory_id')->primary();
            $table->string('name', 45)->nullable();
            $table->tinyInteger('active_flag')->nullable();
            $table->string('brand', 45)->nullable();
            $table->string('model', 45)->nullable();
            $table->string('code', 45)->nullable();
            $table->string('description', 45)->nullable();
            $table->integer('category_id');
            
            $table->index('category_id', 'fk_Inventory_Categories1_idx');
            $table->foreign('category_id')
                ->references('category_id')
                ->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory');
    }
};
