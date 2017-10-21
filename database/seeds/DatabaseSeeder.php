<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Seeder\VehicleSeeder;
use Illuminate\Database\Seeder\AutoBurglaryTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(VehicleSeeder::class);
        $this->call(AutoBurglaryTableSeeder::class);
    }
}
