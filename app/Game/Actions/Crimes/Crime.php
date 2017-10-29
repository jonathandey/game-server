<?php

namespace App\Game\Actions\Crimes;

use App\Game\Player;
use App\Game\Actions\Action;
use App\Game\Traits\HasTimer;
use App\Presenters\Presentable;
use App\Game\Actions\Actionable;
use App\Presenters\CrimePresenter;
use App\Game\Outcomes\CrimeSkillIncrement;
use App\Game\Interfaces\TimerRestricted;
use App\Game\Outcomes\Rewards\Money as MoneyReward;

class Crime extends Action implements Actionable, TimerRestricted
{
	use Presentable, HasTimer;

	const ATTRIBUTE_NAME = 'name';

	const ATTRIBUTE_MONETARY_MIN = 'monetary_min';

	const ATTRIBUTE_MONETARY_MAX = 'monetary_max';

	const ATTRIBUTE_DIFFICULTY = 'difficulty';

	const TIMER_DURATION = 60;

	const SKILL_SUCCESSFUL_INCREMENT_LOW = 0.02;

	const SKILL_SUCCESSFUL_INCREMENT_HIGH = 0.08;

	const SKILL_FAILED_INCREMENT_LOW = 0.01;

	const SKILL_FAILED_INCREMENT_HIGH = 0.05;

	protected $presenter = CrimePresenter::class;

	public function name($name = null)
	{
		return $this->{self::ATTRIBUTE_NAME};
	}

	public function minPayout(int $minPayout = null)
	{
		return $this->{self::ATTRIBUTE_MONETARY_MIN};
	}

	public function maxPayout(int $maxPayout = null)
	{
		return $this->{self::ATTRIBUTE_MONETARY_MAX};
	}

	public function difficulty(float $difficulty = null)
	{
		return $this->{self::ATTRIBUTE_DIFFICULTY};
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
			(new CrimeSkillIncrement)->between(
				self::SKILL_SUCCESSFUL_INCREMENT_LOW, self::SKILL_SUCCESSFUL_INCREMENT_HIGH
			),
		]);

		return $rewards;
	}

	public function punishments()
	{
		$punishments = collect([
			(new CrimeSkillIncrement)->between(
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