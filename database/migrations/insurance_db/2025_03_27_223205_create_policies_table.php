<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::connection('insurance_db')->create('policies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->uuid('vehicle_id');
            $table->uuid('driver_id')->nullable();
            $table->uuid('company_id');
            $table->string('policy_number', 50)->unique();
            $table->string('coverage_type', 50);
            $table->string('insurance_type');
            $table->string('national_id_owner', 20)->nullable();
            $table->string('national_id_current_owner', 20)->nullable();
            $table->string('national_id_transfer_person', 20)->nullable();
            $table->string('registration_type');
            $table->string('custom_number', 50)->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('premium_amount', 10, 2);
            $table->string('currency', 3)->default('SAR');
            $table->string('status')->default('active');
            $table->date('renewal_date')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('user_id')->references('id')->on('user_db.users')->onDelete('cascade');
            $table->foreign('vehicle_id')->references('id')->on('vehicle_db.vehicles')->onDelete('cascade');
            $table->foreign('driver_id')->references('id')->on('vehicle_db.drivers')->onDelete('set null');
            $table->foreign('company_id')->references('id')->on('insurance_db.insurance_companies')->onDelete('cascade');
            // $table->checkConstraint("insurance_type IN ('new', 'transfer')", 'policies_insurance_type_check');
            // $table->checkConstraint("registration_type IN ('new', 'renew', 'customs_card')", 'policies_registration_type_check');
            // $table->checkConstraint("status IN ('active', 'expired', 'cancelled')", 'policies_status_check');
        });
    }

    public function down()
    {
        Schema::connection('insurance_db')->dropIfExists('policies');
    }
};
