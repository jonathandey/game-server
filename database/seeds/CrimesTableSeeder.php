<?php

use Illuminate\Database\Seeder;
use App\Game\Actions\Crimes\Crime;

class CrimesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Crime::firstOrCreate([
            'name' => 'Pick Pocket a Passerby',
            'monetary_min' => 10.0,
            'monetary_max' => 30.0,
            'difficulty' => .8,
        ]);

        Crime::firstOrCreate([
            'name' => 'Steal from Betty\'s Caffee',
            'monetary_min' => 29.0,
            'monetary_max' => 36.0,
            'difficulty' => 3.2,
        ]);

        Crime::firstOrCreate([
            'name' => 'Steal from Linda\'s Clothing',
            'monetary_min' => 34.0,
            'monetary_max' => 42.0,
            'difficulty' => 6.4,
        ]);

        Crime::firstOrCreate([
            'name' => 'Steal from Frank\'s Garage',
            'monetary_min' => 40.0,
            'monetary_max' => 57.0,
            'difficulty' => 12.8,
        ]);

        Crime::firstOrCreate([
            'name' => 'Steal from Jimmy\'s Liquor Store',
            'monetary_min' => 55.0,
            'monetary_max' => 80.0,
            'difficulty' => 25.6,
        ]);

        Crime::firstOrCreate([
            'name' => 'Rob the the local convenience store',
            'monetary_min' => 90.0,
            'monetary_max' => 150.0,
            'difficulty' => 51.2,
        ]);

        Crime::firstOrCreate([
            'name' => 'Steal from Young\'s Manufacturing',
            'monetary_min' => 170.0,
            'monetary_max' => 230.0,
            'difficulty' => 102.4
        ]);

        Crime::firstOrCreate([
            'name' => 'Rob the Jones Bank',
            'monetary_min' => 250.0,
            'monetary_max' => 400.0,
            'difficulty' => 204.8,
        ]);
    }
}
