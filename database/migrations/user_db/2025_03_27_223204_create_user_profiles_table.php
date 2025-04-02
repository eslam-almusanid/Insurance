<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('user_db')->create('user_profiles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->unique();
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->text('address')->nullable();
            $table->uuid('city_id')->nullable();
            $table->string('license_number', 50)->nullable()->unique();
            $table->string('education_level')->nullable();
            $table->integer('number_of_children')->default(0);
            $table->integer('accidents_last_5_years')->default(0);
            $table->string('license_restrictions')->default('none');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('user_id')->references('id')->on('user_db.users')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('shared_db.cities')->onDelete('set null');
            // $table->checkConstraint("gender IN ('male', 'female', 'other')", 'user_profiles_gender_check');
            // $table->checkConstraint("education_level IN ('none', 'primary', 'secondary', 'bachelor', 'postgraduate')", 'user_profiles_education_check');
            // $table->checkConstraint("license_restrictions IN ('none', 'glasses', 'automatic_only', 'other')", 'user_profiles_restrictions_check');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('user_db')->dropIfExists('user_profiles');    }
};
