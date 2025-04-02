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
            $table->uuidMorphs('attachmentable');

            $table->string('name');
            $table->string('original_name');

            $table->string('mime_type')->nullable();
            $table->string('full_path')->nullable();

            $table->string('disk')->default('local');
            $table->unsignedBigInteger('size');
            $table->string('collection_name')->nullable();
            $table->json('custom_properties')->nullable();
            $table->nullableUuidMorphs('submitable');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('attachments');
    }
};
