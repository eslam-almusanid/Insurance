<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('national_id', 20)->unique();
            $table->string('name', 255);
            $table->date('date_of_birth')->nullable();
            $table->string('license_number', 50)->unique();
            $table->string('relationship_to_user')->default('self');
            $table->integer('years_of_experience')->default(0);
            $table->boolean('work_city_same_as_address')->default(false);
            $table->foreignUuid('work_city_id')->nullable()->constrained('cities')->onDelete('set null');
            $table->boolean('has_international_license')->default(false);
            $table->string('international_license_country', 100)->nullable();
            $table->integer('international_license_years')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('drivers');
    }
};
