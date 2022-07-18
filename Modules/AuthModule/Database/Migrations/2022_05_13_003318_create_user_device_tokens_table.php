<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_device_tokens', function (Blueprint $table) {
            $table->id();
            $table->index('phone_uuid');//TODO:MM2 add compound index here (phone_uuid,device_os) as you always search with
            $table->index('user_details.id');
            $table->index('user_details.on_model');
            //TODO:MM2 why you add theses indices
            $table->index('lat');
            $table->index('lng');
            $table->index('device_os');
            $table->index('app_type');
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
        Schema::dropIfExists('user_device_tokens');
    }
};
