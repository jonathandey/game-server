<?php

namespace App\Presenters;

use App\StolenVehicle;
use Illuminate\Http\Request;
use App\Game\Items\Vehicles\Vehicle;

class AutoBurglaryPresenter extends CrimeActionPresenter
{
	protected $unformattedSuccessMessage = 'Your attempt to %s was successful! You got away in a %s with %d%% damage.';

	protected function outcomeMessageAttributes()
	{
		$awards = ($this->action->awards()) ?: null;

		$attributes = [
			$this->action->name(),
		];

		if (! is_null($awards)) {
			$stolenVehicle = $awards->first(function($i) {
				return $i instanceof StolenVehicle ? $i : false;
			});
		}

		if (isset($stolenVehicle)) {
			$attributes[] = $stolenVehicle->vehicle->make;
			$attributes[] = $stolenVehicle->damage;
		} else {
			$attributes[] = 'Error';
			$attributes[] = 100;
		}

		return $attributes;
	}
}