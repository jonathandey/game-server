<?php

namespace App\Presenters;

use App\Game\Game;
use App\Game\Actions\Action;

abstract class ActionPresenter extends Presenter
{
	protected $action = null;

	protected $unformattedSuccessMessage = 'Your attempt to %s was successful!';

	protected $unformattedFailedMessage = 'You failed to %s.';

	public function __construct(Action $action)
	{
		$this->action = $action;
	}

	public function outcomeMessage()
	{
		$classes = ['alert'];
		$unformattedMessage = $this->unformattedFailedMessage;

		if ($this->action->successful()) {
			$unformattedMessage = $this->unformattedSuccessMessage;

			return $this->htmlSuccessMessage(
				$this->formatOutcomeMessage($unformattedMessage)
			);
		}

		return $this->htmlErrorMessage(
			$this->formatOutcomeMessage($unformattedMessage)
		);
	}

	public function player()
	{
		return app(Game::class)->player();
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
			$this->action->name(),
		];
	}
}