<?php

namespace App\Game;

use App\Game\Player;
use App\Game\Items\Item;
use App\Game\Actions\Gym\Gym;
use App\Game\Items\Vehicles\Vehicle;
use Illuminate\Support\Collection;
use App\Game\Actions\Crimes\Crime;
use App\Game\Outcomes\CrimeSkillIncrement;
use App\Game\Outcomes\Gym\SkillIncrement as GymSkillIncrement;
use App\Game\Actions\Crimes\AutoBurglary;
use App\Game\Outcomes\Rewards\Money as MoneyReward;
use App\Game\Outcomes\Rewards\Items\Item as ItemReward;

class Game
{
	protected $name = 'Rum Running';

	protected $crimes = [];

	protected $autoBurglaries = [];

	protected $vehicles = [];

	protected $dice = null;

	protected static $instance = null;

	public static function instance()
	{
		if (! is_null(self::$instance)) {
			return self::$instance;
		}

		self::$instance = new static;

		return self::$instance;
	}

	public function name()
	{
		return $this->name;
	}

	public function dice($dice = null)
	{
		if (is_null($dice)) {
			return $this->dice;
		}

		$this->dice = $dice;

		return $this;
	}

	public function crime(
		$name, int $minPayout, int $maxPayout, float $difficulty, array $messages)
	{
		$crime = (new Crime)->name($name)
			->minPayout($minPayout)
			->maxPayout($maxPayout)
			->difficulty($difficulty)
		;

		if (isset($messages[Crime::MESSAGE_ATTRIBUTE_SUCCESSFUL])) {
			$crime = $crime->successfulMessage($messages[Crime::MESSAGE_ATTRIBUTE_SUCCESSFUL]);
		}

		if (isset($messages[Crime::MESSAGE_ATTRIBUTE_FAILED])) {
			$crime = $crime->failedMessage($messages[Crime::MESSAGE_ATTRIBUTE_FAILED]);
		}

		return $crime;
	}

	public function crimes(array $crimes = null)
	{
		if (is_null($crimes)) {
			return $this->crimes;
		}

		foreach ($crimes as $crime) {
			$this->crimes[] = $this->crime(
				$crime['name'],
				$crime['minPayout'],
				$crime['maxPayout'],
				$crime['difficulty'],
				$crime['messages']
			);
		}
	}

	public function workouts()
	{
		return Gym::get();
	}

	public function autoBurglaries()
	{
		return AutoBurglary::get();
	}

	public function vehicles(Collection $vehicles = null)
	{
		return Vehicle::get();
	}

	public function player()
	{
		return request()->user()->load(['attribute', 'timer']);
	}

	public function rewardPlayer(Collection $rewards = null, Player $player)
	{
		if (is_null($rewards)) {
			return null;
		}

		$awarded = collect();
		$rewards->each(function($reward) use ($player, &$awarded) {
			$value = $reward->value();

			if ($reward instanceof MoneyReward) {
				$value = floor($value);
				$player->addMoney(
					$value
				);
			}

			if ($reward instanceof CrimeSkillIncrement) {
				$player->attribute->incrementCrimeSkill(
					$value
				);
			}

			if ($reward instanceof GymSkillIncrement) {
				$player->attribute->incrementGymSkill($reward);
			}

			if ($reward instanceof ItemReward) {
				$player->give(
					$value
				);
			}

			$awarded->push($value);
		});

		return $awarded;
	}

	public function punishPlayer(Collection $punishments = null, Player $player)
	{
		if (is_null($punishments)) {
			return null;
		}

		$punishments->each(function($punishment) use ($player) {
			// if ($punishment instanceof JailTime) {
			// 	$player->goTo(Jail::class)->until($punishment->timeout());
			// 	$player->goTo(Jail::class)->forSeconds($punishment->timeout());
			// }

			if ($punishment instanceof CrimeSkillIncrement) {
				$player->attribute->incrementCrimeSkill(
					$punishment->value()
				);
			}
		});
	}
}