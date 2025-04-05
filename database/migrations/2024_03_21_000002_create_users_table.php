<?php

use App\Enums\TokenTypesEnum;
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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('national_id', 20)->unique();
            $table->string('name', 255);
            $table->string('email', 255)->unique()->nullable();
            $table->string('password', 255)->nullable();
            $table->string('phone', 20)->unique();
            $table->string('status')->default('active')->comment('active, suspended');
            $table->enum('role', TokenTypesEnum::getValues())->default(TokenTypesEnum::USER);
            $table->enum('language', ['ar', 'en'])->default('ar');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
