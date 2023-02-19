<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_target_sub_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255)->default('');
            $table->unsignedTinyInteger('discard')->default(0);
            $table->timestamp('created')->nullable();
            $table->timestamp('updated')->default(\DB::raw('CURRENT_TIMESTAMP'));
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('target_id')->nullable();
            $table->string('target_table', 50)->nullable();
            $table->unsignedInteger('target_sub_type_id')->nullable();
            $table->text('payload')->nullable();
            $table->unsignedTinyInteger('discard')->default(0);
            $table->timestamp('website_read')->nullable();
            $table->timestamp('email_read')->nullable();
            $table->timestamp('mobile_notification_read')->nullable();
            $table->timestamp('push_notification_read')->nullable();
            $table->timestamp('created')->nullable();
            $table->timestamp('updated')->default(\DB::raw('CURRENT_TIMESTAMP'));

            $table->index('user_id', 'user_id');
            $table->index('target_sub_type_id', 'target_sub_type_id');
            $table->index('target_id', 'target_id');
            $table->index('target_table', 'target_table');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification');
    }
}
