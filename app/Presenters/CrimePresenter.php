<?php

namespace App\Presenters;

use App\Game\Helpers\Money;

class CrimePresenter extends CrimeActionPresenter
{
	protected $unformattedSuccessMessage = 'Your attempt to %s was successful! You got away with %s.';

	protected function outcomeMessageAttributes()
	{
		$awards = ($this->action->awards()) ?: null;

		$attributes = [
			$this->action->name(),
		];

		if (! is_null($awards)) {
			$attributes[] = (new Money)->numberFormatWithSymbol($awards->first());
		}

		return $attributes;
	}
}