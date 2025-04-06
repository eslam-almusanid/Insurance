<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('offer_number', 50)->unique();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignUuid('company_id')->nullable()->constrained('insurance_companies')->onDelete('set null');
            $table->foreignUuid('vehicle_id')->constrained('vehicles')->cascadeOnDelete();
            $table->foreignUuid('driver_id')->nullable()->constrained('drivers')->onDelete('set null');
            $table->string('type');
            $table->string('insurance_type');
            $table->string('national_id', 20)->nullable();
            $table->string('seller_national_id', 20)->nullable();
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
            $table->timestamps();


            $table->index(['user_id', 'vehicle_id', 'driver_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('offers');
    }
};
