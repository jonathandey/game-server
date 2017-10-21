<?php

namespace Illuminate\Database\Seeder;

use Illuminate\Database\Seeder;
use App\Game\Items\Vehicles\Vehicle;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Vehicle::firstOrCreate([
        	'make' => 'Duesenburg',
        	'value' => 1200.00,
        ]);

		Vehicle::firstOrCreate([
        	'make' => 'Comet',
        	'value' => 400.00,
        ]);

		Vehicle::firstOrCreate([
        	'make' => 'Stutz',
        	'value' => 200.00,
        ]);
    }
}
