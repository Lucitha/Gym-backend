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
        Schema::create('format_status', function (Blueprint $table) {
            $table->integer('format_statut_id')->primary();
            $table->string('name', 45)->nullable();
            $table->string('description', 45)->nullable();
            $table->tinyInteger('active_flag')->nullable();
            $table->integer('courses_id');
            
            $table->index('courses_id', 'fk_Format_status_Courses1_idx');
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
        Schema::dropIfExists('format_status');
    }
};
