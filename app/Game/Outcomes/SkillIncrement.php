<?php

namespace App\Game\Outcomes;

use App\Game\Game;

class SkillIncrement extends Outcome
{
	protected $value = 0;

	public function __construct($value = 0)
	{
		$this->value = $value;
	}

	public function value()
	{
		return $this->value;
	}

	public function between(float $min, float $max)
	{
		$this->value = app(Game::class)->dice()->roll($min, $max);

		return $this;
	}
}