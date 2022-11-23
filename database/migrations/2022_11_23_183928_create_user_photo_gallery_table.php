<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPhotoGalleryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photo_gallery', function (Blueprint $table) {
            $table->id();
            $table->string('photo', 255);
            $table->string('name', 255)->nullable();
            $table->unsignedTinyInteger('discard')->default(0);
            $table->unsignedInteger('provider_id')->nullable()->default(0);
            $table->timestamps();

            $table->index('provider_id', 'provider_id');
            $table->index([
                'provider_id',
                'photo',
            ], 'provider_id_photo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('photo_gallery');
    }
}
