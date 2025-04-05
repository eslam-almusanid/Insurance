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
            $table->string('sequence_number', 50)->nullable()->unique();
            $table->string('plate_char_ar', 15);
            $table->string('plate_char_en', 15);
            $table->string('plate_number_ar', 15);
            $table->string('plate_number_en', 15);
            $table->string('make', 50);
            $table->string('model', 50);
            $table->integer('year')->nullable();
            $table->string('color', 50);
            $table->string('type', 50);
            $table->string('modification_status', 50);
            $table->string('vin', 50)->unique();
            $table->string('registration_date', 50);
            $table->string('owner_name', 50);
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();

            $table->integer('month')->nullable();
            $table->integer('manufacture_year')->nullable();
            $table->string('status')->default('active');
            $table->string('parking_location')->default('street');
            $table->string('transmission_type')->default('automatic');
            $table->string('expected_annual_mileage')->default('1-20000');
            $table->boolean('has_trailer')->default(false);
            $table->boolean('used_for_racing')->default(false);
            $table->boolean('has_modifications')->default(false);
            $table->integer('load')->default(0);
            $table->decimal('price', 10, 2)->nullable();
            $table->timestamps();


            $table->index(['user_id', 'vin']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
};
