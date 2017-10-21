<?php

use App\Game\Player;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPlayerAttributesToUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->unsignedInteger(Player::ATTRIBUTE_MONEY)->default(0);
            $table->float(Player::ATTRIBUTE_SKILL)->default(0.1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn(Player::ATTRIBUTE_MONEY, Player::ATTRIBUTE_SKILL);
        });
    }
}
