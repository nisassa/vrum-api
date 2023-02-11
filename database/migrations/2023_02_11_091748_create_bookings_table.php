<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();     
            $table->string('status');
            $table->unsignedTinyInteger('discard')->default(0);
            $table->timestamp('preferred_date')->nullable();    
            
            $table->unsignedTinyInteger('cancelled')->default(0);
            $table->timestamp('cancelled_at')->nullable();    
            $table->string('cancelled_reason')->nullable();    
            $table->timestamp('change_created_at')->nullable();    
            
            $table->unsignedTinyInteger('rejected')->default(0);
            $table->timestamp('rejected_at')->nullable();    
            $table->integer('rejected_by')->default(0);
            $table->string('rejected_reason')->nullable();

            $table->foreign('provider_id')->references('id')->on('providers')->onDelete('cascade');
            $table->foreign('staff_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('car_id')->references('id')->on('cars')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
