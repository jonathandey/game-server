<?php

namespace Illuminate\Database\Seeder;

use Illuminate\Database\Seeder;
use App\Game\Actions\Crimes\AutoBurglary;

class AutoBurglaryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        AutoBurglary::firstOrCreate([
        	'name' => 'Steal from the street',
        	'difficulty' => 5.0,
        ]);

		AutoBurglary::firstOrCreate([
        	'name' => 'Pickpocket keys',
        	'difficulty' => 8.5,
        ]);

		AutoBurglary::firstOrCreate([
        	'name' => 'Steal from private parking lot',
        	'difficulty' => 12.0,
        ]);
    }
}
