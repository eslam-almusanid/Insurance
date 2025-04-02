<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignUuid('policy_id')->constrained('policies')->cascadeOnDelete();
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('SAR');
            $table->string('method');
            $table->string('status')->default('pending');
            $table->string('transaction_id', 50);
            $table->timestamp('payment_date');
            $table->softDeletes();
            $table->timestamps();

            $table->index(['user_id', 'policy_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
