<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150)->default('');
            $table->text('notes')->nullable();
            $table->unsignedTinyInteger('display')->default(1);
            $table->unsignedTinyInteger('discard')->default(0);
            $table->string('position')->default('0');
            $table->timestamps();
            $table->unsignedInteger('provider_id')->nullable()->default(0);
            $table->unsignedTinyInteger('auto_allocation')->default(1);
            $table->float('cost')->default(0.0);
            $table->float('vat')->default(0.0);

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
        Schema::dropIfExists('service_types');
    }
}
