<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkingDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('working_days', function (Blueprint $table) {
            $table->id();
            $table->string('day');
            $table->time('start_at')->nullable();
            $table->time('end_at')->nullable();
            $table->unsignedInteger('provider_id')->nullable()->default(0);
            $table->unsignedInteger('user_id')->nullable()->default(0);
            $table->unsignedTinyInteger('is_active')->default(0);

            $table->index('provider_id', 'provider_id');
            $table->index('user_id', 'user_id');
            
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
        Schema::dropIfExists('working_days');
    }
}
