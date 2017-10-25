<?php

namespace App\Game;

use App\Timer;
use Carbon\Carbon;
use App\BoxingMatch;
use App\StolenVehicle;
use App\PlayerAttribute;
use App\Game\Items\Item;
use App\Game\Actions\Actionable;
use App\Presenters\PlayerPresenter;
use App\Presenters\Presentable;
use Illuminate\Notifications\Notifiable;
use App\Game\Interfaces\TimerRestricted;
use App\Game\Exceptions\TimerNotReadyException;
use App\Game\Exceptions\NotEnoughMoneyException;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Player extends Authenticatable
{
	use Notifiable, Presentable;

	const ATTRIBUTE_MONEY = 'money';

	protected $presenter = PlayerPresenter::class;

	public function commit(Actionable $action)
	{
		if (! $this->canAttempt($action)) {
			$timer = $this->timer->for(
				$action->getTimerName()
			);

			throw new TimerNotReadyException($timer);
		}

		$action->as($this)->attempt();

		if ($action->failed()) {
			app(Game::class)->punishPlayer($action->punishments(), $this);
		} else {
			$awards = app(Game::class)->rewardPlayer($action->rewards(), $this);
			$action->awards($awards);
		}

		$this->timer->set(
			$action->getTimerName(),
			$action->getTimerDuration()
		);

		return true;
	}

	public function canAttempt($action)
	{
		if ($action instanceof TimerRestricted) {
			$timer = $this->timer->for(
				$action->getTimerName()
			);

			return is_null($timer) || $timer <= Carbon::now();
		}

		return true;
	}

	public function experiencePointsFor($query, $scope)
	{
		return $query->experience()->value($scope);
	}

	public function addMoney($value)
	{
		$this->increment(self::ATTRIBUTE_MONEY, $value);
	}

	protected function takeMoney($value)
	{
		$this->decrement(self::ATTRIBUTE_MONEY, $value);
	}

	public function tryToTakeMoney($value)
	{
		if ($this->{self::ATTRIBUTE_MONEY} < $value) {
			throw new NotEnoughMoneyException;
		}

		$this->takeMoney($value);
	}

	public function give($item)
	{
		if ($item instanceof StolenVehicle) {
			$this->vehicles()->save($item);
		}
	}

	public function goTo()
	{

	}

	public function vehicles()
	{
		return $this->hasMany(StolenVehicle::class)
			->where(StolenVehicle::ATTRIBUTE_SOLD, StolenVehicle::PLAYER_SOLD_NO)
			->where(StolenVehicle::ATTRIBUTE_DROPPED, StolenVehicle::PLAYER_DROPPED_NO)
		;
	}

	public function timer()
	{
		return $this->hasOne(Timer::class);
	}

	public function attribute()
	{
		return $this->hasOne(PlayerAttribute::class);
	}

	public function boxingMatches()
	{
		return $this->hasMany(BoxingMatch::class, 'originator_user_id');
	}
}