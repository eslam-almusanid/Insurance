<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('type', 50);
            $table->string('title', 255);
            $table->text('body');
            $table->boolean('read_status')->default(false);
            $table->timestamp('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};
