<?php

namespace App\Http\Controllers\Game;

use Validator;
use App\BoxingMatch;
use App\Http\Requests\PostFight;
use App\Notifications\WonBoxingMatch;
use App\Notifications\LostBoxingMatch;
use App\Notifications\DrawnBoxingMatch;
use App\Game\Actions\Gym\CommenceBoxingMatch;
use App\Game\Exceptions\NotEnoughMoneyException;

class BoxingController extends Controller
{
	protected $invalidFightMessage = null;

	public function __construct()
	{
		parent::__construct();

		$this->invalidFightMessage = $this->basicPresenter()->htmlErrorMessage(
			'Invalid fight!'
		);
	}

	public function create(PostFight $request)
	{
		$attributes = $this->request()->only(['monetary_stake', 'taunt']);

		try {
			$this->player()->tryToTakeMoney($attributes['monetary_stake']);

			$boxingMatch = new BoxingMatch($attributes);
			$this->player()->boxingMatches()->save($boxingMatch);

			$this->message(
				$this->basicPresenter()->htmlSuccessMessage("Your fight has been posted")
			);

		} catch (NotEnoughMoneyException $e) {
			$this->message(
				$this->basicPresenter()->htmlErrorMessage("You don't have that kind of money!")
			);
		}

		return $this->response()->redirectBackWithMessage($this->message());
	}

	public function fight()
	{
		$boxingMatch = BoxingMatch::active()
			->findOrFail(
				$this->request()->get('fight_id')
			)
		;

		if ($this->request()->has('cancel')) {
			return $this->cancelFight($boxingMatch);
		}

		return $this->attemptFight($boxingMatch);
	}

	protected function attemptFight(BoxingMatch $boxingMatch)
	{
		if ($boxingMatch->originator->getKey() == $this->player()->getKey()) {
			$this->message(
				$this->invalidFightMessage
			);

			return $this->response()->redirectBackWithMessage($this->message());
		}

		try {
			$this->player()->tryToTakeMoney(
				$boxingMatch->{BoxingMatch::ATTRIBUTE_MONETARY_STAKE}
			);

			$boxingMatch->{BoxingMatch::ATTRIBUTE_MONETARY_STAKE} += 
				$boxingMatch->{BoxingMatch::ATTRIBUTE_MONETARY_STAKE};

			$boxingMatch->{BoxingMatch::ATTRIBUTE_CHALLENGER_USER_ID} = $this->player()->getKey();

			$boxingMatch->save();
		} catch(NotEnoughMoneyException $e) {
			$this->message(
				$this->basicPresenter()->htmlErrorMessage(
					'You do not have enough money to challenge this fighter'
				)
			);

			return $this->response()->redirectBackWithMessage($this->message());
		}
		
		$fight = $this->commenceFight($boxingMatch, $this->player())->fight();
		$fightReward = $this->calculateFightReward($boxingMatch);

		if ($fight->wasADraw()) {
			$boxingMatch->{BoxingMatch::ATTRIBUTE_DRAW} = true;
			$boxingMatch->save();

			$fight->originator()->notify(new DrawnBoxingMatch($boxingMatch, $fightReward));

			$fightReward = $fightReward / 2;
			return $this->fightDrawResult($fight, $fightReward);
		}

		if ($fight->winner()->getKey() == $fight->challenger()->getKey()) {
			$boxingMatch->{BoxingMatch::ATTRIBUTE_VICTOR_USER_ID} = $fight->challenger()->getKey();
			$boxingMatch->save();

			$fight->originator()->notify(
				new LostBoxingMatch($boxingMatch, $boxingMatch->{BoxingMatch::ATTRIBUTE_MONETARY_STAKE})
			);

			return $this->fightWonResult($fight, $fightReward);
		}

		if ($fight->winner()->getKey() == $fight->originator()->getKey()) {
			$boxingMatch->{BoxingMatch::ATTRIBUTE_VICTOR_USER_ID} = $fight->originator()->getKey();
			$boxingMatch->save();

			$fight->originator()->notify(
				new WonBoxingMatch($boxingMatch, $boxingMatch->{BoxingMatch::ATTRIBUTE_MONETARY_STAKE})
			);
			
			return $this->fightLostResult($fight, $fightReward);
		}
	}

	protected function fightDrawResult($fight, $reward)
	{
		$fight->originator()->addMoney($reward);
		$fight->challenger()->addMoney($reward);

		$this->message(
			$this->basicPresenter()->htmlInfoMessage(
				'The fight ended with no clear winner. The steak was split.'
			)
		);

		return $this->response()->redirectBackWithMessage($this->message());
	}

	protected function fightWonResult($fight, $reward)
	{
		$fight->challenger()->addMoney($reward);

		$this->message(
			$this->basicPresenter()->htmlSuccessMessage(
				'You knocked the living daylights out of them!'
			)
		);

		return $this->response()->redirectBackWithMessage($this->message());
	}

	protected function fightLostResult($fight, $reward)
	{
		$fight->originator()->addMoney($reward);

		$this->message(
			$this->basicPresenter()->htmlErrorMessage(
				'You got the crap beaten out of you...'
			)
		);

		return $this->response()->redirectBackWithMessage($this->message());	
	}

	protected function calculateFightReward(BoxingMatch $boxingMatch)
	{
		$fee = round($boxingMatch->{BoxingMatch::ATTRIBUTE_MONETARY_STAKE} * BoxingMatch::FIGHT_FEE);
		
		return $boxingMatch->{BoxingMatch::ATTRIBUTE_MONETARY_STAKE} - $fee;	
	}

	protected function commenceFight($boxingMatch, $challenger)
	{
		return new CommenceBoxingMatch($boxingMatch, $challenger);
	}

	protected function cancelFight(BoxingMatch $boxingMatch)
	{
		if ($boxingMatch->originator->getKey() != $this->player()->getKey()) {
			$this->message($this->invalidFightMessage);
		} else {
			// Give the player their money back
			$this->player()->addMoney(
				$boxingMatch->{BoxingMatch::ATTRIBUTE_MONETARY_STAKE}
			);

			$boxingMatch->delete();

			$this->message(
				$this->basicPresenter()->htmlSuccessMessage(
					'You backed down from the fight'
				)
			);
		}

		return $this->response()->redirectBackWithMessage($this->message());
	}
}