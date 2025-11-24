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
        Schema::create('duration_types', function (Blueprint $table) {
            $table->integer('duration_type_id')->primary();
            $table->string('Duration_type', 45)->nullable();
            $table->tinyInteger('active_flag')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('duration_types');
    }
};
