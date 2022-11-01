<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone', 100)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->unsignedInteger('provider_id')->nullable()->default(0);
            $table->unsignedTinyInteger('admin');
            $table->unsignedTinyInteger('developer');
            $table->unsignedTinyInteger('discard');
            $table->unsignedTinyInteger('manager')->default(0);
            $table->string('type', 50)->nullable();
            $table->string('job_title', 255)->nullable();
            $table->string('photo', 255)->nullable();
            $table->string('landline', 100)->nullable();
            $table->string('line_1', 255)->nullable();
            $table->string('line_2', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('county', 255)->nullable();
            $table->string('postcode', 50)->nullable();
            $table->string('lat', 255)->nullable();
            $table->string('long', 255)->nullable();

            $table->rememberToken();
            $table->timestamps();

            $table->index('provider_id', 'provider_id');
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
    }
}
