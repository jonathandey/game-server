<?php

namespace App\Game\Actions\Crimes;

use App\Game\Game;
use App\Game\Player;
use App\Game\Actions\Action;
use App\Game\Traits\HasTimer;
use App\Presenters\Presentable;
use App\Game\Actions\Actionable;
use App\Presenters\AutoBurglaryPresenter;
use App\Game\Outcomes\SkillIncrement;
use App\Game\Items\Vehicles\Vehicle;
use App\Game\Interfaces\TimerRestricted;
use App\Game\Outcomes\Rewards\Items\Vehicle as VehicleReward;

class AutoBurglary extends Action implements Actionable, TimerRestricted
{
	use Presentable, HasTimer;

	const TIMER_DURATION = 120;

	const SKILL_SUCCESSFUL_INCREMENT_LOW = 0.02;

	const SKILL_SUCCESSFUL_INCREMENT_HIGH = 0.08;

	const SKILL_FAILED_INCREMENT_LOW = 0.01;

	const SKILL_FAILED_INCREMENT_HIGH = 0.05;

	protected $presenter = AutoBurglaryPresenter::class;

	protected $maxChancePercentage = 50;

	public function name($name = null)
	{
		return $this->name;
	}

	public function difficulty(float $difficulty = null)
	{
		return $this->difficulty;
	}

	public function vehicles()
	{
		return $this->belongsToMany(Vehicle::class, 'auto_burglary_vehicles')
			->withPivot('rarity_min', 'rarity_max')
		;
	}

	public function attempt()
	{
		return $this->skilledAttempt();
	}

	public function rewards()
	{
		$rewards = collect([
			(new SkillIncrement)->between(
				self::SKILL_SUCCESSFUL_INCREMENT_LOW, self::SKILL_SUCCESSFUL_INCREMENT_HIGH
			),
		]);

		// Does this auto burglary have any vehicles associated with it?
		$vehicles = $this->vehicles;
		if ($vehicles->count()) {
			$rewards->push(
				(new VehicleReward)->items($vehicles)
			);
		}

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