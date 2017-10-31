<?php

namespace App\Game\Outcomes\Travel;

use App\Game\Actions\Travel\Transport;

class TravelDestination
{
	protected $transport;

	public function __construct(Transport $transport)
	{
		$this->transport = $transport;
	}

	public function value()
	{
		return $this->transport
			->destination()
			->getLocation()
		;
	}
}