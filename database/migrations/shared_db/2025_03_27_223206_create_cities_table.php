<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::connection('shared_db')->create('cities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name_ar', 100);
            $table->string('name_en', 100);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    public function down()
    {
        Schema::connection('shared_db')->dropIfExists('cities');
    }
};
