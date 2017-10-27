<?php

namespace App\Http\Controllers\Game;

use App\BoxingMatch;
use App\Game\Actions\Gym\Gym;
use App\Http\Requests\GymTraining;
use App\Game\Exceptions\TimerNotReadyException;

class GymController extends ActionController
{
	protected $actionClass = Gym::class;

	protected $view = 'game.actions.gym';

	public function index()
	{
		$timer = $this->timer();

		$boxingMatches = BoxingMatch::active()
			->orderBy(BoxingMatch::ATTRIBUTE_MONETARY_STAKE, 'desc')
			->get()
		;

		$attributes = [
			'actions' => $this->game()->workouts()
				->sortBy(Gym::ATTRIBUTE_SKILL_POINTS)
				->groupBy(Gym::ATTRIBUTE_TYPE),
			'action' => $this->action(),
			'fights' => $boxingMatches,
		];

		if (! is_null($timer) && ! $timer->isReady()) {
			$attributes['timer'] = $timer->diffNow();
		}

		return view($this->view, $attributes);
	}

	public function commit(GymTraining $request)
	{
		$workoutId = $this->request()->get('workout');
		$workout = $this->game()->workouts()->find($workoutId);

		try {
			$this->game()->player()->commit($workout);
			$message = $workout->presenter()->outcomeMessage();
		} catch (TimerNotReadyException $e) {

		}
		
		return redirect()->back()->with(compact('message'));
	}
}