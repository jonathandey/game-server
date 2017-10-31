<?php

namespace App\Game;

use App\Timer;
use App\Location;
use Carbon\Carbon;
use App\Game\Game;
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

	const ATTRIBUTE_LAST_ACTIVE_AT = 'last_active_at';

	const ATTRIBUTE_LOCATION_ID = 'location_id';

	const PRESENCE_STATUS_OFFLINE = 0;

	const PRESENCE_STATUS_ONLINE = 1;

	const PRESENCE_STATUS_IDLE = 2;

	const PRESENCE_STATUS_ONLINE_TIME = 120;

	const PRESENCE_STATUS_IDLE_TIME = 1800;

	protected $presenter = PlayerPresenter::class;

	protected $appends = [
		'wealthStatus',
	];

	public function commit(Actionable $action)
	{
		if (! $this->canCommit($action)) {
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

	public function goTo($location)
	{
		if ($location instanceof Location) {
			$location->players()->save($this);
		}
	}

	public function canCommit($action)
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
		if ($this->canAfford($value)) {
			throw new NotEnoughMoneyException;
		}

		$this->takeMoney($value);
	}

	public function canAfford($value)
	{
		return $this->{self::ATTRIBUTE_MONEY} < $value;
	}

	public function ifCanCommitTryToTakeMoney(Actionable $action, $value)
	{
		if ($this->canCommit($action)) {
			return $this->tryToTakeMoney($value);
		}

		return false;
	}

	public function give($item)
	{
		if ($item instanceof StolenVehicle) {
			$item->{StolenVehicle::ATTRIBUTE_ORIGIN_LOCATION_ID} = $this->{self::ATTRIBUTE_LOCATION_ID};
			$item->{StolenVehicle::ATTRIBUTE_LOCATION_ID} = $this->{self::ATTRIBUTE_LOCATION_ID};
			$this->vehicles()->save($item);
		}
	}

	public function location()
	{
		return $this->belongsTo(Location::class);
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

	public function updateActiveTime()
	{
		$this->{self::ATTRIBUTE_LAST_ACTIVE_AT} = $this->freshTimestamp();
		$this->save();
	}

	public function logout()
	{
		$this->{self::ATTRIBUTE_LAST_ACTIVE_AT} = null;
		$this->save();
	}

	public function getWealthStatusAttribute()
	{
		$status = app(Game::class)->wealthStatuses()
			->where('min', '<=', $this->{self::ATTRIBUTE_MONEY})
			->where('max', '>=', $this->{self::ATTRIBUTE_MONEY})
			->first()
		;

		if (! is_null($status)) {
			return $status['name'];
		}

		return 'Broke';
	}

	public function scopeOnline($query)
	{
		$query->whereNotNull(self::ATTRIBUTE_LAST_ACTIVE_AT)
			->where(
				self::ATTRIBUTE_LAST_ACTIVE_AT, '>=', $this->idleTimeAgo()
			)
		;
	}

	public function isOnline()
	{
		return ! is_null($this->{self::ATTRIBUTE_LAST_ACTIVE_AT}) &&
			$this->{self::ATTRIBUTE_LAST_ACTIVE_AT} >= $this->onlineTimeAgo()
		;
	}

	public function isIdle()
	{
		return ! is_null($this->{self::ATTRIBUTE_LAST_ACTIVE_AT}) &&
			$this->{self::ATTRIBUTE_LAST_ACTIVE_AT} <= $this->onlineTimeAgo()
			&& $this->{self::ATTRIBUTE_LAST_ACTIVE_AT} > $this->idleTimeAgo()
		;
	}

	public function isOffline()
	{
		return is_null($this->{self::ATTRIBUTE_LAST_ACTIVE_AT});
	}

	public function presenceStatus()
	{
		if ($this->isIdle()) {
			return self::PRESENCE_STATUS_IDLE;
		}

		if ($this->isOnline()) {
			return self::PRESENCE_STATUS_ONLINE;
		}

		return self::PRESENCE_STATUS_OFFLINE;
	}

	protected function onlineTimeAgo()
	{
		return (new Carbon)->subSeconds(self::PRESENCE_STATUS_ONLINE_TIME);
	}

	protected function idleTimeAgo()
	{
		return (new Carbon)->subSeconds(self::PRESENCE_STATUS_IDLE_TIME);
	}
}