<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::connection('insurance_db')->create('payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->uuid('policy_id')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('SAR');
            $table->string('method');
            $table->string('status')->default('pending');
            $table->string('transaction_id', 50)->nullable();
            $table->timestamp('payment_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('user_id')->references('id')->on('user_db.users')->onDelete('cascade');
            $table->foreign('policy_id')->references('id')->on('insurance_db.policies')->onDelete('set null');
            // $table->checkConstraint("method IN ('Mada', 'Visa', 'ApplePay', 'SADAD')", 'payments_method_check');
            // $table->checkConstraint("status IN ('paid', 'pending', 'failed')", 'payments_status_check');
        });
    }

    public function down()
    {
        Schema::connection('insurance_db')->dropIfExists('payments');
    }
};
