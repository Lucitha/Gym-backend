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
        Schema::create('settings', function (Blueprint $table) {
            $table->integer('setting_id')->primary();
            $table->string('company', 45)->nullable();
            $table->string('logo', 45)->nullable();
            $table->string('horraires', 45)->nullable();
            $table->string('description', 45)->nullable();
            $table->string('contacts', 45)->nullable();
            $table->string('social_link', 45)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
