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
        Schema::create('registrations', function (Blueprint $table) {
            $table->integer('registration_id')->primary();
            $table->dateTime('creation_date')->nullable();
            $table->integer('user_id');
            $table->integer('courses_id');
            
            $table->index('user_id', 'fk_Registrations_Users1_idx');
            $table->index('courses_id', 'fk_Registrations_Courses1_idx');
            
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
                
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
        Schema::dropIfExists('registrations');
    }
};
