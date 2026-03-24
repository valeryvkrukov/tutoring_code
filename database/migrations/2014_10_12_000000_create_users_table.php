<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            // fix for better integration with newest Laravel versions and to avoid potential issues with auto-incrementing IDs
            $table->id('id');
            
            $table->string('first_name', 100);
            $table->string('last_name', 100)->nullable();

            // it's better to manage role constants in model.
            // default value 'customer' and indexed for faster queries
            $table->string('role', 20)->default('customer')->index();

            // email field is essential for user authentication and communication, so it's important to keep it unique and indexed for better performance
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // address fields grouped together for better organization
            $table->string('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('zip', 20)->nullable();
            $table->string('time_zone', 100)->nullable();

            // status field (better string with index for faster queries instead of enum)
            $table->string('status', 20)->default('inactive')->index();

            // !! phone number should be stored as string to accommodate different formats and potential leading zeros
            $table->string('phone')->nullable();

            // content fields
            $table->string('image')->nullable();
            $table->longText('description')->nullable();
            
            $table->rememberToken();
            $table->timestamps();

            // maybe interesting for future: add soft deletes for better data management and recovery
            // $table->softDeletes();
        });

        /*Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name',50);
            $table->string('last_name',50)->nullable();
            $table->enum('role', ['admin', 'customer','tutor']);
            $table->string('email')->unique();
            // $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('address',255)->nullable();
            $table->string('city',50)->nullable();
            $table->string('state',50)->nullable();
            $table->string('zip',20)->nullable();
            // fix #2: time_zone field added
            $table->string('time_zone',50)->nullable();
            $table->enum('status', ['inactive','active']);
            $table->bigInteger('phone')->nullable();
            $table->string('image')->nullable();
            $table->longText('description')->nullable();

            $table->rememberToken();
            $table->timestamps();
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
