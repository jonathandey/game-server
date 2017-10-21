<?php

namespace App\Presenters;

use App\Game\Actions\Action;

abstract class ActionPresenter extends Presenter
{
	protected $crime = null;

	protected $request = null;

	protected $unformattedSuccessMessage = 'Your attempt to %s was successful!';

	protected $unformattedFailedMessage = 'You failed to %s.';

	public function __construct(Action $crime)
	{
		$this->crime = $crime;

		$this->request = request();
	}

	public function playerPercentage()
	{
		return $this->crime->for(
				$this->request->user()
			)
			->skillPercentageChance()
		;
	}

	public function outcomeMessage()
	{
		$classes = ['alert'];
		$unformattedMessage = $this->unformattedFailedMessage;

		if ($this->crime->successful()) {
			$unformattedMessage = $this->unformattedSuccessMessage;

			return $this->htmlSuccessMessage(
				$this->formatOutcomeMessage($unformattedMessage)
			);
		}

		return $this->htmlErrorMessage(
			$this->formatOutcomeMessage($unformattedMessage)
		);
	}

	protected function formatOutcomeMessage($unformattedMessage)
	{
		return call_user_func_array('sprintf', array_merge(
			[$unformattedMessage], $this->outcomeMessageAttributes()
		));
	}

	protected function outcomeMessageAttributes()
	{
		return [
			$this->crime->name(),
		];
	}
}