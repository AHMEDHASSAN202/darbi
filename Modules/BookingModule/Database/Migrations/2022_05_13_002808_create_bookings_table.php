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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->index('vendor_id');
            $table->index('user_id');
            $table->index('branch_id');
            $table->index('port_id');
            $table->index('country_id');
            $table->index('entity_id');
            $table->index('city_id');
            $table->index('status');
            $table->index('created_at');
            $table->index('accepted_at');
            $table->index('pending_at');
            $table->dateTime('start_booking_at');
            $table->dateTime('end_booking_at');
            $table->dateTime('start_trip_at');
            $table->dateTime('end_trip_at');
            $table->dateTime('accepted_at');
            $table->dateTime('pending_at');
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
        Schema::dropIfExists('bookings');
    }
};
