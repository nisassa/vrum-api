<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings_items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedTinyInteger('discard')->default(0);
            
            $table->unsignedBigInteger('services_id')->default(0);
            $table->unsignedBigInteger('booking_id')->default(0);

            $table->float('cost')->default(0.0);
            $table->float('vat')->default(0.0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings_items');
    }
}
