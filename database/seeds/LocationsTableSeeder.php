<?php

use App\Location;
use Illuminate\Database\Seeder;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Location::firstOrCreate([
    		'name' => 'New Jersey',
    	]);

    	Location::firstOrCreate([
    		'name' => 'New York',
    	]);

    	Location::firstOrCreate([
    		'name' => 'Illinois',
    	]);

    	Location::firstOrCreate([
    		'name' => 'California',
    	]);
    }
}
