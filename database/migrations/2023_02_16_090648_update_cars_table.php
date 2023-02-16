<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cars', function (Blueprint $table) {            
            $table->unsignedBigInteger('client_id')->default(0)->change();
            $table->unsignedBigInteger('offline_client_id')->default(0);            
        });

        Schema::table('bookings', function (Blueprint $table) {            
            $table->text('client_notes')->nullable()->change();
            $table->text('provider_notes')->nullable()->change();  
            $table->dropForeign('bookings_rejected_by_foreign');
            $table->dropForeign('bookings_staff_id_foreign');
        });

        Schema::table('bookings_items', function (Blueprint $table) {
            $table->dropForeign('bookings_items_services_id_foreign');
        });

        Schema::table('bookings_items', function (Blueprint $table) {
            $table->foreign('services_id')->references('id')->on('service_types')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
