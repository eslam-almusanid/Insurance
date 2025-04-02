<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('subjectable_type', 255);
            $table->uuid('subjectable_id');
            $table->string('name', 255);
            $table->string('original_name', 255);
            $table->string('mime_type', 255);
            $table->string('full_path', 255);
            $table->string('disk', 255);
            $table->bigInteger('size');
            $table->json('custom_properties')->nullable();
            $table->string('collection_name', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('attachments');
    }
};
