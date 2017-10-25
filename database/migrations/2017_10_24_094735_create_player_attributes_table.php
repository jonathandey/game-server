<?php

use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayerAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->float('crime_skill')->default(0);
            $table->unsignedInteger('gym_strength_progress')->default(0);
            $table->unsignedInteger('gym_strength_level')->default(0);
            $table->unsignedInteger('gym_stamina_progress')->default(0);
            $table->unsignedInteger('gym_stamina_level')->default(0);
            $table->unsignedInteger('gym_agility_progress')->default(0);
            $table->unsignedInteger('gym_agility_level')->default(0);
        });

        User::chunk(100, function ($users) {
            foreach ($users as $user) {
                DB::table('player_attributes')->insert([
                    'user_id' => $user->getKey(),
                    'crime_skill' => $user->skill,
                ]);
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
        Schema::dropIfExists('player_attributes');
    }
}
