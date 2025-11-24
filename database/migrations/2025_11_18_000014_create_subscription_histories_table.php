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
        Schema::create('subscription_histories', function (Blueprint $table) {
            $table->integer('subscription_history_id')->primary();
            $table->date('creation_date')->nullable();
            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable();
            $table->date('next_due_date')->nullable();
            $table->tinyInteger('active_flag')->nullable();
            $table->integer('subscription_type_id');
            $table->integer('user_id');
            $table->integer('subscription_status_id');
            
            $table->index('subscription_type_id', 'fk_subscription_histories_Subscription_types1_idx');
            $table->index('user_id', 'fk_subscription_histories_Users1_idx');
            $table->index('subscription_status_id', 'fk_Subscription_histories_Subscription_status1_idx');
            
            $table->foreign('subscription_type_id')
                ->references('subscription_type_id')
                ->on('subscription_types');
                
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
                
            $table->foreign('subscription_status_id')
                ->references('subscription_status_id')
                ->on('subscription_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_histories');
    }
};
