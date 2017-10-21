<?php

namespace App\Presenters;
use App\Game\Helpers\Money;

use App\StolenVehicle;

class StolenVehiclePresenter extends Presenter
{
	protected $stolenVehicle = null;

	protected $request = null;

	public function __construct(StolenVehicle $stolenVehicle)
	{
		$this->stolenVehicle = $stolenVehicle;

		$this->request = request();
	}

	public function make()
	{
		return $this->stolenVehicle->vehicle->make;
	}

	public function damage()
	{
		return sprintf('%d%%', $this->stolenVehicle->damage);
	}

	public function value()
	{
		return (new Money)->numberFormat(
			$this->stolenVehicle->value()
		);
	}

	public function valueWithSymbol()
	{
		return (new Money)->numberFormatWithSymbol(
			$this->stolenVehicle->value()
		);
	}
}