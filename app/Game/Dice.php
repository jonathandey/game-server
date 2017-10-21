<?php

namespace App\Game;

class Dice
{
	public function roll($min = 0, $max = 100)
	{
        $min = $min * 10000;
        $max = $max * 10000;

        $rand = random_int($min, $max);

        return round($rand / 10000, 2);
	}
}