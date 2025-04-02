<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
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
            $table->timestamps();


            $table->index(['user_id', 'vin']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
};
