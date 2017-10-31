<?php

namespace App\Game\Actions\Travel;

use App\Location;
use App\Game\Game;
use App\Game\Actions\Travel\Train\Destination;
use App\Game\Outcomes\Travel\TravelDestination;

class Train extends Transport
{
	const TIMER_DURATION = 3600;

	protected $destination;

	public function name()
	{
		return 'Train Station';
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
		return collect([
			new TravelDestination($this)
		]);
	}

	public function punishments()
	{
		return collet();
	}

	public function startingLocation(Location $startingLocation = null)
	{
		if (is_null($startingLocation)) {
			return $this->startingLocation;
		}

		$this->startingLocation = $startingLocation;

		return $this;
	}

	public function destination(Destination $destination = null)
	{
		if (is_null($destination)) {
			return $this->destination;
		}

		$this->destination = $destination;

		return $this;
	}

	public function destinations()
	{
		$destinations = collect();

		app(Game::class)->travelDestinations()
			->where('from', '=', $this->startingLocation->getKey())
			->each(function ($destination) use (&$destinations) {
				$destinations->push(
					$this->createDestination(
						Location::find($destination['to']),
						$destination['distance']
					)
				);
			})
		;

		return $destinations;
	}

	public function findDestination(Location $locationDestination)
	{
		$line = app(Game::class)->travelDestinations()
			->where('from', '=', $this->startingLocation->getKey())
			->where('to', '=', $locationDestination->getKey())
			->first()
		;

		return $this->createDestination($locationDestination, $line['distance']);
	}

	public function getTimerDuration()
	{
		return self::TIMER_DURATION;
	}

	protected function createDestination(Location $location, $distance)
	{
		return new Destination($location, $distance);
	}
}