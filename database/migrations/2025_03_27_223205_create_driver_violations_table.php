<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('driver_violations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('driver_id')->constrained('drivers')->cascadeOnDelete();
            $table->string('violation_type');
            $table->date('violation_date');
            $table->decimal('fine_amount', 10, 2)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index('driver_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('driver_violations');
    }
};
