<?php

namespace App\Http\Controllers\Game;

use Validator;
use App\BoxingMatch;
use App\Game\Actions\Gym\CommenceBoxingMatch;
use App\Game\Exceptions\NotEnoughMoneyException;

class BoxingController extends Controller
{
	protected $invalidFightMessage = "<div class='alert alert-danger'>Invalid fight!</div>";

	public function create()
	{
		$validation = Validator::make(
			$this->request()->all(), 
			[
				'monetary_stake' => 'required|min:1|numeric',
				'taunt' => 'max:40',
			]
		);

		if ($validation->fails()) {
			return redirect()->back()
				->withErrors($validation)
				->withInput()
			;
		}

		$attributes = $this->request()->only(['monetary_stake', 'taunt']);

		try {
			$this->player()->tryToTakeMoney($attributes['monetary_stake']);

			$boxingMatch = new BoxingMatch($attributes);
			$this->player()->boxingMatches()->save($boxingMatch);

			$message = "<div class='alert alert-success'>Your fight has been posted.</div>";
			return redirect()->back()->with(compact('message'));

		} catch (NotEnoughMoneyException $e) {
			$message = "<div class='alert alert-danger'>You don't have that kind of money!</div>";
			return redirect()->back()->with(compact('message'));
		}
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
			$message = $this->invalidFightMessage;
			return redirect()->back()->with(compact('message'));
		}

		try {
			$this->player()->tryToTakeMoney(
				$boxingMatch->{BoxingMatch::ATTRIBUTE_MONETARY_STAKE}
			);
			$boxingMatch->{BoxingMatch::ATTRIBUTE_MONETARY_STAKE} += 
				$boxingMatch->{BoxingMatch::ATTRIBUTE_MONETARY_STAKE};

			$boxingMatch->save();
		} catch(NotEnoughMoneyException $e) {
			$message = "<div class='alert alert-danger'>You do not have enough money to challenge this fighter</div>";
			return redirect()->back()->with(compact('message'));
		}
		
		$fight = $this->commenceFight($boxingMatch)->fight();

		$fee = round($boxingMatch->{BoxingMatch::ATTRIBUTE_MONETARY_STAKE} * 0.05);
		$totalReward = $boxingMatch->{BoxingMatch::ATTRIBUTE_MONETARY_STAKE} - $fee;	

		if ($fight->wasADraw()) {
			$share = $totalReward / 2;

			$fight->originator()->addMoney($share);
			$fight->challenger()->addMoney($share);

			$boxingMatch->{BoxingMatch::ATTRIBUTE_DRAW} = true;
			$boxingMatch->save();

			$message = "<div class='alert alert-info'>The fight ended with no clear winner. The steak was split.</div>";
			return redirect()->back()->with(compact('message'));
		}

		if ($fight->winner()->getKey() == $fight->challenger()->getKey()) {
			$fight->challenger()->addMoney($totalReward);
			$boxingMatch->{BoxingMatch::ATTRIBUTE_VICTOR_USER_ID} = $fight->challenger()->getKey();
			$boxingMatch->save();

			$message = "<div class='alert alert-success'>You knocked the living delights out of them!</div>";
			return redirect()->back()->with(compact('message'));			
		}

		if ($fight->winner()->getKey() == $fight->originator()->getKey()) {
			$fight->originator()->addMoney($totalReward);
			$boxingMatch->{BoxingMatch::ATTRIBUTE_VICTOR_USER_ID} = $fight->originator()->getKey();
			$boxingMatch->save();

			$message = "<div class='alert alert-danger'>You got the crap beaten out of you...</div>";
			return redirect()->back()->with(compact('message'));			
		}
	}

	protected function commenceFight($boxingMatch)
	{
		return new CommenceBoxingMatch($boxingMatch, $this->player());
	}

	protected function cancelFight(BoxingMatch $boxingMatch)
	{
		if ($boxingMatch->originator->getKey() != $this->player()->getKey()) {
			$message = $this->invalidFightMessage;
		} else {
			// Give the player their money back
			$this->player()->addMoney(
				$boxingMatch->{BoxingMatch::ATTRIBUTE_MONETARY_STAKE}
			);

			$boxingMatch->delete();

			$message = "<div class='alert alert-success'>You backed down from the fight</div>";
		}

		return redirect()->back()->with(compact('message'));
	}
}