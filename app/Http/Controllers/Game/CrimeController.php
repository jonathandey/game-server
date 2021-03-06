<?php

namespace App\Http\Controllers\Game;

use App\Game\Actions\Crimes\Crime;
use App\Game\Exceptions\TimerNotReadyException;

class CrimeController extends ActionController
{
	protected $actionClass = Crime::class;

	protected $view = 'game.actions.crime';

	public function commit()
	{
		$crimeId = $this->request()->get('crime');
		$crime = $this->game()->crimes()[$crimeId];

		try {
			$this->game()->player()->commit($crime);
			$message = $crime->presenter()->outcomeMessage();
		} catch (TimerNotReadyException $e) {

		}
		
		return redirect()->back()->with(compact('message'));
	}
}