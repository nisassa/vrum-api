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
            
            $table->text('client_notes');
            $table->text('provider_notes');

            $table->unsignedTinyInteger('discard')->default(0);
            $table->timestamp('preferred_date')->nullable();    
            
            $table->timestamp('cancelled_at')->nullable();    
            $table->string('cancelled_reason')->nullable();    
            $table->timestamp('change_created_at')->nullable();    
            
            $table->timestamp('rejected_at')->nullable();    
            $table->unsignedBigInteger('rejected_by')->default(0);
            $table->string('rejected_reason')->nullable();

            $table->unsignedBigInteger('provider_id');
            $table->unsignedBigInteger('staff_id')->default(0);
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('car_id');
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
