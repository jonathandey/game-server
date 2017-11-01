<?php

namespace App\Http\Controllers\Game;

use App\Http\Requests\Travel;
use App\Game\Actions\Travel\Train;
use App\Game\Exceptions\TimerNotReadyException;
use App\Game\Exceptions\NotEnoughMoneyException;

class TravelController extends ActionController
{
	protected $train = null;

	protected $actionClass = Train::class;

	public function index()
	{
		$destinations = $this->getTrain()->destinations();

		return $this->withTimer()
			->response()
			->view('game.travel.train', compact('destinations'))
		;
	}

	public function travel(Travel $request)
	{
		$player = $this->player();
		$train = $this->getTrain();

		$destinationId = $this->request()->get('destination');
		$destinationLocation = $this->game()->locations()->find($destinationId);

		$train->destination(
			$train->findDestination($destinationLocation)
		);

		try {
			$player->ifCanCommitTryToTakeMoney(
				$this->getTrain(), $train->destination()->price()
			);

			$player->commit($this->getTrain());

			$this->message(
				$train->presenter()->outcomeMessage()
			);
		} catch(NotEnoughMoneyException $e) {
			$this->message(
				$train->presenter()->htmlErrorMessage($e->getMessage())
			);
		} catch (TimerNotReadyException $e) {

		}
		
		return $this->response()->redirectBackWithMessage($this->message());
	}

	protected function getTrain()
	{
		return $this->game()->train();
	}
}