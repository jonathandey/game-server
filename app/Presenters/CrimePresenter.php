<?php

namespace App\Presenters;

use App\Game\Helpers\Money;

class CrimePresenter extends ActionPresenter
{
	protected $unformattedSuccessMessage = 'Your attempt to %s was successful! You got away with %s.';

	protected function outcomeMessageAttributes()
	{
		$awards = ($this->crime->awards()) ?: null;

		$attributes = [
			$this->crime->name(),
		];

		if (! is_null($awards)) {
			$attributes[] = (new Money)->numberFormatWithSymbol($awards->first());
		}

		return $attributes;
	}
}