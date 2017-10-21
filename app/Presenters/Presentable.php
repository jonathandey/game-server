<?php

namespace App\Presenters;

use App\Presenters\Exceptions\PresenterNotSetException;
use App\Presenters\Exceptions\PresenterClassNotFoundException;

trait Presentable
{
	public function presenter()
	{
		if (! isset($this->presenter)) {
			throw new PresenterNotSetException(
				'No presenter set on class ' . get_class($this)
			);
		}

		if (! class_exists($this->presenter)) {
			throw new PresenterClassNotFoundException(
				"The presenter class ({$this->presenter}) does not exist"
			);
		}

		return new $this->presenter($this);
	}
}