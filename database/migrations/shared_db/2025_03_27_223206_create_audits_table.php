<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::connection('shared_db')->create('audits', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('user_type', 255)->nullable();
            $table->uuid('user_id')->nullable();
            $table->string('event', 255);
            $table->string('auditable_type', 255);
            $table->uuid('auditable_id');
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->string('url', 255)->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 1024)->nullable();
            $table->string('tags', 255)->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('user_id')->references('id')->on('user_db.users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::connection('shared_db')->dropIfExists('audits');
    }
};
