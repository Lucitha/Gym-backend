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
        Schema::create('courses', function (Blueprint $table) {
            $table->integer('courses_id')->primary();
            $table->string('name', 45)->nullable();
            $table->dateTime('date_from')->nullable();
            $table->dateTime('date_to')->nullable();
            $table->integer('course_type_id');
            $table->tinyInteger('active_flag')->nullable();
            
            $table->index('course_type_id', 'fk_Courses_course_types1_idx');
            $table->foreign('course_type_id')
                ->references('course_type_id')
                ->on('course_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
