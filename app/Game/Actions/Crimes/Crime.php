<?php

namespace App\Game\Actions\Crimes;

use App\Game\Player;
use App\Game\Actions\Action;
use App\Game\Traits\HasTimer;
use App\Presenters\Presentable;
use App\Game\Actions\Actionable;
use App\Presenters\CrimePresenter;
use App\Game\Outcomes\SkillIncrement;
use App\Game\Interfaces\TimerRestricted;
use App\Game\Outcomes\Rewards\Money as MoneyReward;

class Crime extends Action implements Actionable, TimerRestricted
{
	use Presentable, HasTimer;

	const TIMER_DURATION = 60;

	const SKILL_SUCCESSFUL_INCREMENT_LOW = 0.02;

	const SKILL_SUCCESSFUL_INCREMENT_HIGH = 0.08;

	const SKILL_FAILED_INCREMENT_LOW = 0.01;

	const SKILL_FAILED_INCREMENT_HIGH = 0.05;

	protected $name = null;

	protected $minPayout = 0;

	protected $maxPayout = 1;

	protected $difficulty = 10.0;

	protected $presenter = CrimePresenter::class;

	public function name($name = null)
	{
		if (is_null($name)) {
			return $this->name;
		}

		$this->name = $name;

		return $this;
	}

	public function minPayout(int $minPayout = null)
	{
		if (is_null($minPayout)) {
			return $this->minPayout;
		}

		$this->minPayout = $minPayout;

		return $this;
	}

	public function maxPayout(int $maxPayout = null)
	{
		if (is_null($maxPayout)) {
			return $this->maxPayout;
		}

		$this->maxPayout = $maxPayout;

		return $this;
	}

	public function difficulty(float $difficulty = null)
	{
		if (is_null($difficulty)) {
			return $this->difficulty;
		}

		$this->difficulty = $difficulty;

		return $this;
	}

	public function attempt()
	{
		return $this->skilledAttempt();
	}

	public function rewards()
	{
		$rewards = collect([
			(new MoneyReward)->between(
				$this->minPayout(), $this->maxPayout()
			),
			(new SkillIncrement)->between(
				self::SKILL_SUCCESSFUL_INCREMENT_LOW, self::SKILL_SUCCESSFUL_INCREMENT_HIGH
			),
		]);

		return $rewards;
	}

	public function punishments()
	{
		$punishments = collect([
			(new SkillIncrement)->between(
				self::SKILL_FAILED_INCREMENT_LOW, self::SKILL_FAILED_INCREMENT_HIGH
			),
		]);

		// Randomise going to jail here

		return $punishments;
	}

	public function getTimerDuration()
	{
		return self::TIMER_DURATION;
	}

	public function percentage()
	{
		return $this->presenter()->playerPercentage();
	}
}