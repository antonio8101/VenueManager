<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersRolePermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('roles', function (Blueprint $table) {
		    $table->increments('id');
		    $table->string('name');
	    });

	    Schema::create('permissions', function (Blueprint $table) {
		    $table->increments('id');
		    $table->string('name');
	    });

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstName');
	        $table->string('lastName');
	        $table->date('birth_date');
	        $table->date('last_activity')->nullable();
	        $table->boolean('password_to_reset');
	        $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->unsignedInteger('role_id')->nullable();
            $table->timestamps();
        });

	    Schema::table('users', function($table) {
		    $table->foreign('role_id')->references('id')->on('roles');
	    });

	    Schema::create('roles_permissions', function (Blueprint $table) {
		    $table->increments('id');
		    $table->unsignedInteger('role_id');
		    $table->unsignedInteger('permission_id');
		    $table->timestamps();
	    });

	    Schema::table('roles_permissions', function($table) {
		    $table->foreign('role_id')->references('id')->on('roles');
		    $table->foreign('permission_id')->references('id')->on('permissions');
	    });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::dropIfExists('users');
	    Schema::dropIfExists('roles_permissions');
	    Schema::dropIfExists('roles');
	    Schema::dropIfExists('permissions');
    }
}
