<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::connection('vehicle_db')->create('vehicles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->string('vin', 50)->unique();
            $table->string('type', 50);
            $table->tinyInteger('model_month');
            $table->tinyInteger('model_year');
            $table->integer('manufacture_year')->nullable();
            $table->string('plate_char_ar', 15);
            $table->string('plate_char_en', 15);
            $table->string('plate_number_ar', 15)->unique();
            $table->string('plate_number_en', 15)->unique();
            $table->string('status')->default('active');
            $table->string('parking_location')->default('street');
            $table->string('transmission_type')->default('automatic');
            $table->string('expected_annual_mileage')->default('1-20000');
            $table->boolean('has_trailer')->default(false);
            $table->boolean('used_for_racing')->default(false);
            $table->boolean('has_modifications')->default(false);
            $table->integer('load')->default(0);
            $table->decimal('price', 10, 2);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->index('user_id');
            $table->index('vin');
            $table->foreign('user_id')->references('id')->on('user_db.users')->onDelete('cascade');
            // $table->checkConstraint("status IN ('active', 'expired', 'sold')", 'vehicles_status_check');
            // $table->checkConstraint("parking_location IN ('street', 'garage', 'parking_lot')", 'vehicles_parking_check');
            // $table->checkConstraint("transmission_type IN ('automatic', 'manual')", 'vehicles_transmission_check');
            // $table->checkConstraint("expected_annual_mileage IN ('1-20000', '20001-40000', '40001-60000', '60001+')", 'vehicles_mileage_check');
        });
    }

    public function down()
    {
        Schema::connection('vehicle_db')->dropIfExists('vehicles');
    }
};
