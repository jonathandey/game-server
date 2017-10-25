<?php

namespace App\Game\Outcomes\Gym;

use App\Game\Outcomes\Outcome;

abstract class SkillIncrement extends Outcome
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
}