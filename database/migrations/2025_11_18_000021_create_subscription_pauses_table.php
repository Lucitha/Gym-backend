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
        Schema::create('subscription_pauses', function (Blueprint $table) {
            $table->integer('subscription_pause_id')->primary();
            $table->date('pause_date')->nullable();
            $table->date('due_date')->nullable();
            $table->integer('subscription_history_id');
            
            $table->index('subscription_history_id', 'fk_subscription_pauses_Subscription_histories1_idx');
            $table->foreign('subscription_history_id')
                ->references('subscription_history_id')
                ->on('subscription_histories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_pauses');
    }
};
