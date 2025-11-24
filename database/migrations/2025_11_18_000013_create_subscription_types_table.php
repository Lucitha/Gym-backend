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
        Schema::create('subscription_types', function (Blueprint $table) {
            $table->integer('subscription_type_id')->primary();
            $table->string('name', 45)->nullable();
            $table->string('description', 45)->nullable();
            $table->string('amount', 45)->nullable();
            $table->integer('duration_type_id');
            $table->tinyInteger('active_flag')->nullable();
            $table->date('creation_date')->nullable();
            
            $table->index('duration_type_id', 'fk_Subscription_types_Duration_types1_idx');
            $table->foreign('duration_type_id')
                ->references('duration_type_id')
                ->on('duration_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_types');
    }
};
