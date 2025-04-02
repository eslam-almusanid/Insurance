<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::connection('shared_db')->create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->string('type', 50);
            $table->string('title', 255);
            $table->text('body');
            $table->boolean('read_status')->default(false);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('user_id')->references('id')->on('user_db.users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::connection('shared_db')->dropIfExists('notifications');
    }
};
