<?php

namespace App\Game\Actions\Travel\Train;

use App\Location;

class Destination
{
	const BASE_PRICE = 37;

	protected $location = null;

	protected $distance = 0;

	public function __construct(Location $location, $distance)
	{
		$this->location = $location;

		$this->distance = $distance;
	}

	public function id()
	{
		return $this->location->getKey();
	}

	public function name()
	{
		return $this->location->name;
	}

	public function price()
	{
		return $this->distance * self::BASE_PRICE;
	}

	public function population()
	{
		return $this->location->players()->count();
	}

	public function getLocation()
	{
		return $this->location;
	}
}