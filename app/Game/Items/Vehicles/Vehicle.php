<?php

namespace App\Game\Items\Vehicles;

use App\Game\Game;
use App\StolenVehicle;
use App\Game\Items\Item;
use App\Presenters\Presentable;
use App\Presenters\VehiclePresenter;

class Vehicle extends Item
{
	use Presentable;

	const ATTRIBUTE_MIN_RARITY = 'rarity_min';

	const ATTRIBUTE_MAX_RARITY = 'rarity_max';

	protected $presenter = VehiclePresenter::class;

	public function stolen()
	{
		return $this->hasMany(StolenVehicle::class);
	}

}