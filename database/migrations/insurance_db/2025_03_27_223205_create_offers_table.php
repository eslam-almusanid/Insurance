<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::connection('insurance_db')->create('offers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('offer_number', 50)->unique();
            $table->uuid('user_id');
            $table->uuid('company_id')->nullable();
            $table->uuid('vehicle_id');
            $table->uuid('driver_id')->nullable();
            $table->string('type');
            $table->string('insurance_type');
            $table->string('national_id_owner', 20)->nullable();
            $table->string('national_id_current_owner', 20)->nullable();
            $table->string('national_id_transfer_person', 20)->nullable();
            $table->string('registration_type');
            $table->string('custom_number', 50)->nullable();
            $table->decimal('price', 10, 2);
            $table->string('currency', 3)->default('SAR');
            $table->string('repair_type');
            $table->date('expiration_date')->nullable();
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->string('status')->default('pending');
            $table->boolean('has_previous_claim')->default(false);
            $table->text('notes')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->index('user_id');
            $table->index('vehicle_id');
            $table->index('driver_id');
            $table->foreign('user_id')->references('id')->on('user_db.users')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('insurance_db.insurance_companies')->onDelete('set null');
            $table->foreign('vehicle_id')->references('id')->on('vehicle_db.vehicles')->onDelete('cascade');
            $table->foreign('driver_id')->references('id')->on('vehicle_db.drivers')->onDelete('set null');
            // $table->checkConstraint("type IN ('comprehensive', 'third_party')", 'offers_type_check');
            // $table->checkConstraint("insurance_type IN ('new', 'transfer')", 'offers_insurance_type_check');
            // $table->checkConstraint("registration_type IN ('new', 'renew', 'customs_card')", 'offers_registration_type_check');
            // $table->checkConstraint("repair_type IN ('agency', 'workshop')", 'offers_repair_type_check');
            // $table->checkConstraint("status IN ('pending', 'accepted', 'rejected')", 'offers_status_check');
        });
    }

    public function down()
    {
        Schema::connection('insurance_db')->dropIfExists('offers');
    }
};
