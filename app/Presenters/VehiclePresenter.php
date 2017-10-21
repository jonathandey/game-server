<?php

namespace App\Presenters;

use App\Game\Items\Vehicles\Vehicle;

class VehiclePresenter extends Presenter
{
	protected $vehicle = null;

	protected $request = null;

	public function __construct(Vehicle $vehicle)
	{
		$this->vehicle = $vehicle;

		$this->request = request();
	}

	public function damage()
	{
		return sprintf('%d%%', $this->vehicle->pivot->damage);
	}

	public function value()
	{
		return sprintf('$%d', $this->vehicle->actualValue());
	}
}