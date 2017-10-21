<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStolenVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stolen_vehicles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('vehicle_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('damage')->default(50);
            $table->unsignedInteger('origin_location')->default(0);
            $table->unsignedInteger('location')->default(0);
            $table->boolean('dropped')->default(false);
            $table->boolean('sold')->default(false);
            $table->boolean('garaged')->default(false);
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
        Schema::dropIfExists('stolen_vehicles');
    }
}
