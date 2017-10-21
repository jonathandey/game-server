<?php

namespace App\Game\Outcomes\Rewards\Items;

use App\Game\Game;
use App\StolenVehicle;
use Illuminate\Support\Collection;
use App\Game\Items\Vehicles\Vehicle as VehicleModel;

class Vehicle extends Item
{
	protected $items = null;

	protected $value = null;

	public function value()
	{
		if (! is_null($this->value)) {
			return $this->value;
		}

		$this->value = $this->vehicleReward();

		return $this->value;
	}

	public function items(Collection $items)
	{
		$this->items = $items;

		return $this;
	}

	protected function vehicleReward()
	{
		$roll = app(Game::class)->dice()->roll(1, 100);

		$vehicle = $this->items->filter(function ($vehicle) use ($roll) {
			return $vehicle->pivot->{VehicleModel::ATTRIBUTE_MIN_RARITY} <= $roll 
				&& $vehicle->pivot->{VehicleModel::ATTRIBUTE_MAX_RARITY} >= $roll
			;
		})
		->first();

		if (is_null($vehicle)) {
			dd(10, $roll);
		}

		$stolenVehicle = new StolenVehicle;
		$stolenVehicle->vehicle_id = $vehicle->getKey();
		$stolenVehicle->giveDamage();
		
		return $stolenVehicle;
	}
}