<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Schema::create('roles', function (Blueprint $table) {
        //     $table->uuid('id')->primary();
        //     $table->string('name', 255)->unique();
        //     $table->string('guard_name', 255);
        //     $table->timestamp('created_at');
        // });
        // Schema::create('permissions', function (Blueprint $table) {
        //     $table->uuid('id')->primary();
        //     $table->string('name', 255)->unique();
        //     $table->string('guard_name', 255);
        //     $table->timestamp('created_at');
        // });
        // Schema::create('role_has_permissions', function (Blueprint $table) {
        //     $table->uuid('permission_id');
        //     $table->uuid('role_id');
        //     $table->primary(['permission_id', 'role_id']);
        //     $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
        //     $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        // });
        // Schema::create('model_has_permissions', function (Blueprint $table) {
        //     $table->uuid('permission_id');
        //     $table->string('model_type', 255);
        //     $table->uuid('model_id');
        //     $table->primary(['permission_id', 'model_id', 'model_type']);
        //     $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
        //     $table->foreign('model_id')->references('id')->on('users')->onDelete('cascade');
        // });
        // Schema::create('model_has_roles', function (Blueprint $table) {
        //     $table->uuid('role_id');
        //     $table->string('model_type', 255);
        //     $table->uuid('model_id');
        //     $table->primary(['role_id', 'model_id', 'model_type']);
        //     $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        // });
        
    }

    public function down()
    {
        Schema::dropIfExists('model_has_roles');
        Schema::dropIfExists('model_has_permissions');
        Schema::dropIfExists('role_has_permissions');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
        
    }
};
