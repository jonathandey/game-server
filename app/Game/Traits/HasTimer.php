<?php

namespace App\Game\Traits;

trait HasTimer
{
	public function getTimerName()
	{
		if (is_null($this->timerName)) {
			$this->timerName = snake_case(class_basename(get_class($this)));
		}

		return $this->timerName;
	}
}