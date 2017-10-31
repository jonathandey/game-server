<?php

use App\User;
use App\Location;
use App\StolenVehicle;
use Illuminate\Database\Seeder;

class AssignUserAndVehicleLocations extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::where(User::ATTRIBUTE_LOCATION_ID, '<=', 0)
        	->get()
        	->map(function ($user) {
                $location = Location::get()->shuffle()->first();
                $location->players()->save($user);
	        })
		;

        StolenVehicle::where(StolenVehicle::ATTRIBUTE_ORIGIN_LOCATION_ID, '<=', 0)
        	->get()
        	->map(function ($vehicle) {
                $originLocation = Location::get()->shuffle()->first();
                $parkedLocation = Location::where((new Location)->getKeyName(), '!=', $originLocation->getKey())
                	->inRandomOrder()
                    ->first()
                ;

                $originLocation->stolenVehicles()->save($vehicle);
                $parkedLocation->parkedVehicles()->save($vehicle);
	        })
		;
    }
}
