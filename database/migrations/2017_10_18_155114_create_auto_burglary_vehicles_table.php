<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutoBurglaryVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auto_burglary_vehicles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('auto_burglary_id');
            $table->unsignedInteger('vehicle_id');
            $table->unsignedInteger('rarity_min');
            $table->unsignedInteger('rarity_max');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auto_burglary_vehicles');
    }
}
