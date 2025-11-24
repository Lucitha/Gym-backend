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
        Schema::create('medias', function (Blueprint $table) {
            $table->integer('media_id')->primary();
            $table->tinyInteger('active_flag')->nullable();
            $table->string('description', 45)->nullable();
            $table->string('link', 45)->nullable();
            $table->integer('type_media_id');
            $table->integer('user_id');
            
            $table->index('type_media_id', 'fk_Medias_Type_medias1_idx');
            $table->index('user_id', 'fk_Medias_Users1_idx');
            
            $table->foreign('type_media_id')
                ->references('type_media_id')
                ->on('type_medias');
                
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medias');
    }
};
