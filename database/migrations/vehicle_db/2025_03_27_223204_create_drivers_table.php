<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::connection('vehicle_db')->create('drivers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->string('national_id', 20)->unique();
            $table->string('name', 255);
            $table->date('date_of_birth')->nullable();
            $table->string('license_number', 50)->unique();
            $table->string('relationship_to_user')->default('self');
            $table->integer('years_of_experience')->default(0);
            $table->boolean('work_city_same_as_address')->default(false);
            $table->uuid('work_city_id')->nullable();
            $table->boolean('has_international_license')->default(false);
            $table->string('international_license_country', 100)->nullable();
            $table->integer('international_license_years')->default(0);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('user_id')->references('id')->on('user_db.users')->onDelete('cascade');
            $table->foreign('work_city_id')->references('id')->on('shared_db.cities')->onDelete('set null');
            // $table->checkConstraint("relationship_to_user IN ('self', 'spouse', 'child', 'employee', 'other')", 'drivers_relationship_check');
        });
    }

    public function down()
    {
        Schema::connection('vehicle_db')->dropIfExists('drivers');
    }
};
