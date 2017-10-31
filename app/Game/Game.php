<?php

namespace App\Game;

use App\User;
use App\Location;
use App\Game\Player;
use App\Game\Items\Item;
use App\Game\Actions\Gym\Gym;
use App\Game\Actions\Travel\Train;
use Illuminate\Support\Collection;
use App\Game\Actions\Crimes\Crime;
use App\Game\Items\Vehicles\Vehicle;
use App\Game\Actions\Crimes\AutoBurglary;
use App\Game\Outcomes\CrimeSkillIncrement;
use App\Game\Outcomes\Travel\TravelDestination;
use App\Game\Outcomes\Rewards\Money as MoneyReward;
use App\Game\Outcomes\Rewards\Items\Item as ItemReward;
use App\Game\Outcomes\Gym\SkillIncrement as GymSkillIncrement;

class Game
{
	protected $name = 'Rum Running';

	protected $crimes = [];

	protected $autoBurglaries = [];

	protected $vehicles = [];

	protected $wealthStatuses = [];

	protected $locationDistances = [];

	protected $dice = null;

	protected $train = null;

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

	public function locations()
	{
		return Location::get();
	}

	public function crimes()
	{
		return Crime::get();
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

	public function train()
	{
		if (! is_null($this->train)) {
			return $this->train;
		}

		return $this->train = (new Train)->startingLocation(
			$this->player()->location
		);
	}

	public function player()
	{
		return request()->user()->load([
			'attribute', 'timer', 'location',
		]);
	}

	public function usersOnline()
	{
		return User::online()->get();
	}

	public function wealthStatuses(array $wealthStatuses = null)
	{
		if (is_null($wealthStatuses)) {
			return collect($this->wealthStatuses);
		}

		$this->wealthStatuses = $wealthStatuses;

		return $this;
	}	

	public function travelDestinations(array $travelDestinations = null)
	{
		if (is_null($travelDestinations)) {
			return collect($this->travelDestinations);
		}

		$this->travelDestinations = $travelDestinations;

		return $this;
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

			if ($reward instanceof TravelDestination) {
				$player->goTo(
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