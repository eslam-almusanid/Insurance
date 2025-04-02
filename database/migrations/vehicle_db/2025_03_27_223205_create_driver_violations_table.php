<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::connection('vehicle_db')->create('driver_violations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('driver_id');
            $table->string('violation_type');
            $table->date('violation_date');
            $table->decimal('fine_amount', 10, 2)->nullable();
            $table->text('description')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->index('driver_id');
            $table->foreign('driver_id')->references('id')->on('vehicle_db.drivers')->onDelete('cascade');
            // $table->checkConstraint("violation_type IN ('speeding', 'red_light', 'wrong_way', 'drifting', 'illegal_parking', 'other')", 'violations_type_check');
        });
    }

    public function down()
    {
        Schema::connection('vehicle_db')->dropIfExists('driver_violations');
    }
};
