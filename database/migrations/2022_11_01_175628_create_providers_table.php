<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150)->default('');
            $table->string('live_api_key', 255)->nullable();
            $table->string('test_api_key', 255)->nullable();
            $table->string('invoice_email', 255)->nullable();
            $table->tinyInteger('vip')->default(0);
            $table->unsignedTinyInteger('discard')->default(0);
            $table->string('line_1', 255)->nullable();
            $table->string('line_2', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('county', 255)->nullable();
            $table->string('country', 255)->nullable();
            $table->string('postcode', 50)->nullable();
            $table->string('lat', 255)->nullable();
            $table->string('long', 255)->nullable();
            $table->tinyInteger('booking_by_specialist')->default(0);
            $table->unsignedInteger('booking_auto_allocation')->nullable()->default(0);
            $table->string('landline', 100)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('providers');
    }
}
