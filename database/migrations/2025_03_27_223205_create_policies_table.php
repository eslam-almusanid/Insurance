<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('policies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignUuid('vehicle_id')->constrained('vehicles')->cascadeOnDelete();
            $table->foreignUuid('driver_id')->nullable()->constrained('drivers')->onDelete('set null');
            $table->foreignUuid('company_id')->nullable()->constrained('insurance_companies')->onDelete('set null');
            $table->string('policy_number', 50)->unique();
            $table->string('coverage_type', 50);
            $table->string('insurance_type');
            $table->string('national_id', 20)->nullable();
            $table->string('seller_national_id', 20)->nullable();
            $table->string('registration_type');
            $table->string('custom_number', 50)->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('premium_amount', 10, 2);
            $table->string('currency', 3)->default('SAR');
            $table->string('status')->default('active');
            $table->date('renewal_date')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'vehicle_id', 'driver_id', 'policy_number']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('policies');
    }
};
