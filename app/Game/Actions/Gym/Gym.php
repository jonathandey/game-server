<?php

namespace App\Game\Actions\Gym;

use App\Game\Actions\Action;
use App\Presenters\Presentable;
use App\Game\Actions\Actionable;
use App\Presenters\GymPresenter;
use App\Game\Interfaces\TimerRestricted;
use App\Game\Outcomes\Gym\AgilitySkillIncrement;
use App\Game\Outcomes\Gym\StaminaSkillIncrement;
use App\Game\Outcomes\Gym\StrengthSkillIncrement;

class Gym extends Action implements Actionable, TimerRestricted
{
	use Presentable;

	const ATTRIBUTE_SKILL_POINTS = 'skill_points';

	const ATTRIBUTE_TIMER_DURATION = 'rest_time';

	const ATTRIBUTE_TYPE = 'type';

	const TYPE_STRENGTH = 1;

	const TYPE_STAMINA = 2;

	const TYPE_AGILITY = 3;

	const LEVEL_INCREMENT = 15;

	public $timestamps = false;

	protected $table = 'gym';

	protected $presenter = GymPresenter::class;

	public function name($name = null)
	{
		return $this->name;
	}

	public function difficulty(float $difficulty = null)
	{
		return 0;
	}

	public function attempt()
	{
		return $this->successfulAttempt();
	}

	public function rewards()
	{
		if ($this->{self::ATTRIBUTE_TYPE} == self::TYPE_AGILITY) {
			return collect([
				new AgilitySkillIncrement($this->{self::ATTRIBUTE_SKILL_POINTS}),
			]);
		}

		if ($this->{self::ATTRIBUTE_TYPE} == self::TYPE_STAMINA) {
			return collect([
				new StaminaSkillIncrement($this->{self::ATTRIBUTE_SKILL_POINTS}),
			]);
		}

		if ($this->{self::ATTRIBUTE_TYPE} == self::TYPE_STRENGTH) {
			return collect([
				new StrengthSkillIncrement($this->{self::ATTRIBUTE_SKILL_POINTS}),
			]);
		}
	}

	public function punishments()
	{
		return collect();
	}

	public function getTimerName()
	{
		return 'gym';
	}

	public function getTimerDuration()
	{
		return $this->{self::ATTRIBUTE_TIMER_DURATION};
	}
}