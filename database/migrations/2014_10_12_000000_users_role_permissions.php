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
            $table->boolean('active')->default(true);
            $table->string('firstName');
	        $table->string('lastName');
	        $table->date('birth_date');
	        $table->string('email')->unique();
            $table->string('password');
            $table->string('profile_image')->nullable();
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

	    Schema::create('login_table', function (Blueprint $table) {
		    $table->increments('id');
		    $table->boolean('active');
		    $table->string('token')->unique();
		    $table->unsignedInteger('user_id');
		    $table->dateTime('last_activity')->nullable();
		    $table->unsignedInteger('duration')->default(0);
		    $table->timestamps();
	    });

	    Schema::table('login_table', function($table) {
		    $table->foreign('user_id')->references('id')->on('users');
	    });

	    Schema::create( 'addresses', function ( Blueprint $table ) {
		    $table->increments( 'id' );
		    $table->string( 'name' )->nullable();
		    $table->string( 'city' );
		    $table->string( 'street' );
		    $table->string( 'countryId' ); // iso 3
		    $table->string( 'countryName' ); // iso 3
		    $table->decimal( 'latitude' );
		    $table->decimal( 'longitude' );
		    $table->string( 'zipCode' )->nullable();
		    $table->timestamps();
	    } );

	    Schema::create('venues', function (Blueprint $table) {
		    $table->increments('id');
		    $table->boolean('active')->default(true);
		    $table->string('name')->nullable();
		    $table->unsignedInteger('address_id');
		    $table->timestamps();
	    });

	    Schema::table('venues', function($table) {
		    $table->foreign('address_id')->references('id')->on('addresses');
	    });

	    Schema::create('users_venues', function (Blueprint $table) {
		    $table->increments('id');
		    $table->unsignedInteger('user_id');
		    $table->unsignedInteger('venue_id');
		    $table->timestamps();
	    });

	    Schema::table('users_venues', function($table) {
		    $table->foreign('venue_id')->references('id')->on('venues');
		    $table->foreign('user_id')->references('id')->on('users');
	    });
	    // VenueToUser Relationship
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::dropIfExists('login_table');
	    Schema::dropIfExists('users_venues');
	    Schema::dropIfExists('users');
	    Schema::dropIfExists('roles_permissions');
	    Schema::dropIfExists('roles');
	    Schema::dropIfExists('permissions');
	    Schema::dropIfExists('venues');
	    Schema::dropIfExists('addresses');
    }
}
