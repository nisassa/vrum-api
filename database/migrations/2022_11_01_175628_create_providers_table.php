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
