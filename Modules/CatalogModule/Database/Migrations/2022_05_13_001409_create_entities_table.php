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
        Schema::create('entities', function (Blueprint $table) {
            $table->id();
            $table->index('model_id');
            $table->index('brand_id');
            $table->index('vendor_id');
            $table->index('country_id');
            $table->index('is_active');
            $table->index('is_available');
            $table->index('state');
            $table->index('type');
            $table->index('branch_id');
            $table->index('unavailable_date.from');
            $table->index('unavailable_date.to');
            $table->softDeletes();
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
        Schema::dropIfExists('entities');
    }
};
