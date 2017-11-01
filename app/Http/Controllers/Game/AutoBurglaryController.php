<?php

namespace App\Http\Controllers\Game;

use App\Game\Actions\Crimes\AutoBurglary;
use App\Http\Requests\CommitAutoBurglary;
use App\Game\Exceptions\TimerNotReadyException;

class AutoBurglaryController extends ActionController
{
	protected $actionClass = AutoBurglary::class;

	protected $view = 'game.actions.auto-burglary';

	public function commit(CommitAutoBurglary $request)
	{
		$autoburglaryId = $this->request()->get('autoBurglary');
		$autoburglary = $this->game()
			->autoBurglaries()
			->find($autoburglaryId)
		;

		try {
			$this->game()->player()->commit($autoburglary);
			$this->message(
				$autoburglary->presenter()->outcomeMessage()
			);
		} catch (TimerNotReadyException $e) {

		}
		
		return $this->response()->redirectBackWithMessage($this->message());
	}
}
