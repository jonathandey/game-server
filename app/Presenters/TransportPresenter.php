<?php

namespace App\Presenters;

class TransportPresenter extends ActionPresenter
{
	protected $unformattedSuccessMessage = 'Welcome to %s!';

	protected function outcomeMessageAttributes()
	{
		return [
			$this->action->awards()->first()->name
		];
	}
}