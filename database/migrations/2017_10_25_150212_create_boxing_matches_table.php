<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoxingMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boxing_matches', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('originator_user_id');
            $table->unsignedInteger('challenger_user_id')->nullable();
            $table->unsignedInteger('victor_user_id')->nullable();
            $table->boolean('draw')->default(false);
            $table->integer('monetary_stake');
            $table->string('taunt')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boxing_matches');
    }
}
