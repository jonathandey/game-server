<?php

use App\User;
use App\Location;
use App\StolenVehicle;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AssignUserAndVehicleLocations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Randomise users location
        User::chunk(100, function ($users) {
            foreach ($users as $user) {
                $location = Location::get()->shuffle()->first();
                $location->players()->save($user);
            }
        });

        StolenVehicle::chunk(100, function ($vehicles) {
            foreach ($vehicles as $vehicle) {
                $originLocation = Location::get()->shuffle()->first();
                $parkedLocation = Location::where((new Location)->getKeyName(), '!=', $originLocation->getKey())
                    ->shuffle()
                    ->first()
                ;

                $location->stolenVehicles()->save($vehicle);
                $location->parkedVehicles()->save($vehicle);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        User::where(User::ATTRIBUTE_LOCATION_ID, '!=', 0)->update([User::ATTRIBUTE_LOCATION_ID => 0]);

        StolenVehicle::where(StolenVehicle::ATTRIBUTE_LOCATION_ID, '!=', 0)
            ->update([StolenVehicle::ATTRIBUTE_LOCATION_ID => 0])
        ;
        StolenVehicle::where(StolenVehicle::ATTRIBUTE_ORIGIN_LOCATION_ID, '!=', 0)
            ->update([StolenVehicle::ATTRIBUTE_ORIGIN_LOCATION_ID => 0])
        ;
    }
}
