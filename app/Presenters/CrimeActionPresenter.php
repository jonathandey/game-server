<?php

namespace App\Presenters;

abstract class CrimeActionPresenter extends ActionPresenter
{
	public function playerPercentage()
	{
		return $this->action->for(
				$this->player()
			)
			->skillPercentageChance()
		;
	}
}