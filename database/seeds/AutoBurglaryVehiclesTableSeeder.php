<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AutoBurglaryVehiclesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('auto_burglary_vehicles')->updateOrInsert([
    		'auto_burglary_id' => 3,
    		'vehicle_id' => 1,
    		'rarity_min' => 71,
    		'rarity_max' => 100,
    	]);

    	DB::table('auto_burglary_vehicles')->updateOrInsert([
    		'auto_burglary_id' => 3,
    		'vehicle_id' => 2,
    		'rarity_min' => 41,
    		'rarity_max' => 70,
    	]);

    	DB::table('auto_burglary_vehicles')->updateOrInsert([
    		'auto_burglary_id' => 3,
    		'vehicle_id' => 3,
    		'rarity_min' => 1,
    		'rarity_max' => 40,
    	]);

    	DB::table('auto_burglary_vehicles')->updateOrInsert([
    		'auto_burglary_id' => 2,
    		'vehicle_id' => 1,
    		'rarity_min' => 86,
    		'rarity_max' => 100,
    	]);

    	DB::table('auto_burglary_vehicles')->updateOrInsert([
    		'auto_burglary_id' => 2,
    		'vehicle_id' => 2,
    		'rarity_min' => 41,
    		'rarity_max' => 85,
    	]);

    	DB::table('auto_burglary_vehicles')->updateOrInsert([
    		'auto_burglary_id' => 2,
    		'vehicle_id' => 3,
    		'rarity_min' => 1,
    		'rarity_max' => 40,
    	]);

    	DB::table('auto_burglary_vehicles')->updateOrInsert([
    		'auto_burglary_id' => 1,
    		'vehicle_id' => 1,
    		'rarity_min' => 96,
    		'rarity_max' => 100,
    	]);

    	DB::table('auto_burglary_vehicles')->updateOrInsert([
    		'auto_burglary_id' => 1,
    		'vehicle_id' => 2,
    		'rarity_min' => 71,
    		'rarity_max' => 95,
    	]);

    	DB::table('auto_burglary_vehicles')->updateOrInsert([
    		'auto_burglary_id' => 1,
    		'vehicle_id' => 3,
    		'rarity_min' => 1,
    		'rarity_max' => 70,
    	]);
    }
}
