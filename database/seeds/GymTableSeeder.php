<?php

use Illuminate\Database\Seeder;

use App\Game\Actions\Gym\Gym;

class GymTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Strength exercises
         */
        Gym::firstOrCreate([
        	'name' => 'Pushups',
        	'type' => Gym::TYPE_STRENGTH,
        	'skill_points' => 3,
        	'rest_time' => 120
        ]);

		Gym::firstOrCreate([
        	'name' => 'Lift weights',
        	'type' => Gym::TYPE_STRENGTH,
        	'skill_points' => 7,
        	'rest_time' => 300
        ]);

		Gym::firstOrCreate([
        	'name' => 'Bench Press',
        	'type' => Gym::TYPE_STRENGTH,
        	'skill_points' => 13,
        	'rest_time' => 600
        ]);

        /**
         * Stamina exercises
         */
		Gym::firstOrCreate([
        	'name' => 'Run the track',
        	'type' => Gym::TYPE_STAMINA,
        	'skill_points' => 3,
        	'rest_time' => 120
        ]);

        Gym::firstOrCreate([
            'name' => 'Exercise Bike',
            'type' => Gym::TYPE_STAMINA,
            'skill_points' => 7,
            'rest_time' => 300
        ]);

        Gym::firstOrCreate([
            'name' => 'Swim Pool Lengths',
            'type' => Gym::TYPE_STAMINA,
            'skill_points' => 13,
            'rest_time' => 600
        ]);

        /**
         * Agility exercises
         */
		Gym::firstOrCreate([
        	'name' => 'Jump Rope',
        	'type' => Gym::TYPE_AGILITY,
        	'skill_points' => 3,
        	'rest_time' => 120
        ]);

        Gym::firstOrCreate([
            'name' => 'Ladder Drills',
            'type' => Gym::TYPE_AGILITY,
            'skill_points' => 7,
            'rest_time' => 300
        ]);

        Gym::firstOrCreate([
            'name' => 'Shadow Box',
            'type' => Gym::TYPE_AGILITY,
            'skill_points' => 13,
            'rest_time' => 600
        ]);

    }
}
