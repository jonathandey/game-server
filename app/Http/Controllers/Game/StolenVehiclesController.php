<?php

namespace App\Http\Controllers\Game;

use App\StolenVehicle;
use App\Game\Items\Vehicles\Vehicle;
use App\Http\Requests\ManageVehicles;
use App\Http\Controllers\Traits\HasModelContext;
use App\Game\Exceptions\NotEnoughMoneyException;

class StolenVehiclesController extends Controller
{
	use HasModelContext;

	protected $modelClass = StolenVehicle::class;

	protected $player;

	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

	public function index()
	{
		$stolenVehicles = $this->game()
			->player()
			->vehicles()
			->orderBy('created_at', 'DESC')
			->get()
		;

		return view('game.actions.garage', compact('stolenVehicles'));
	}

	public function manage(ManageVehicles $request)
	{
		// Todo: Ensure actions are only carried out on vehicles belonging to the player
		$this->player = $this->game()->player();

		$countProccessedVehicles = 0;
		$countSelectedVehicles = count(
			$this->request()->get('selected')
		);

		if ($this->request()->has('drop')) {
			$countProccessedVehicles = $this->dropVehicles();
		}

		if ($this->request()->has('sell')) {
			$countProccessedVehicles = $this->sellVehicles();
		}

		if ($this->request()->has('secure')) {
			$countProccessedVehicles = $this->secureVehicles();
		}

		if ($this->request()->has('park')) {
			$countProccessedVehicles = $this->parkVehicles();
		}

		if ($this->request()->has('repair')) {
			try {
				$countProccessedVehicles = $this->repairVehicles();
			} catch (NotEnoughMoneyException $e) {
				$message = $e->getMessage();
				return redirect()->back()->with(compact('message'));	
			}
		}

		$message = $this->model()->presenter()->htmlInfoMessage(
			"{$countProccessedVehicles} out of {$countSelectedVehicles} vehicles have been processed"
		);

		return redirect()->back()->with(compact('message'));
	}

	protected function dropVehicles()
	{
		$vehicleIds = $this->request()->get('selected');

		$vehiclesProcessed = $this->game()
			->player()
			->vehicles()
			->where(StolenVehicle::ATTRIBUTE_GARAGED, StolenVehicle::PLAYER_GARAGED_NO)
			->whereIn('id', $vehicleIds)
			->update([StolenVehicle::ATTRIBUTE_DROPPED => StolenVehicle::PLAYER_DROPPED_YES])
		;

		return $vehiclesProcessed;
	}

	protected function sellVehicles()
	{
		$vehicleIds = $this->request()->get('selected');

		$vehicles = $this->game()
			->player()
			->vehicles()
			->where(StolenVehicle::ATTRIBUTE_GARAGED, StolenVehicle::PLAYER_GARAGED_NO)
			->where(StolenVehicle::ATTRIBUTE_SOLD, StolenVehicle::PLAYER_SOLD_NO)
			->whereIn('id', $vehicleIds)
		;

		$totalValue = 0;

		$vehicles->get()->each(function($vehicle) use (&$totalValue) {
			$totalValue += $vehicle->value();
		});

		$this->game()->player()->addMoney($totalValue);

		$vehiclesProcessed = $vehicles->update([
			StolenVehicle::ATTRIBUTE_SOLD => StolenVehicle::PLAYER_SOLD_YES
		]);

		return $vehiclesProcessed;
	}

	protected function secureVehicles()
	{
		$vehicleIds = $this->request()->get('selected');

		$vehiclesProcessed = $this->game()
			->player()
			->vehicles()
			->where(StolenVehicle::ATTRIBUTE_GARAGED, StolenVehicle::PLAYER_GARAGED_NO)
			->whereIn('id', $vehicleIds)
			->update([StolenVehicle::ATTRIBUTE_GARAGED => StolenVehicle::PLAYER_GARAGED_YES])
		;

		return $vehiclesProcessed;
	}

	protected function parkVehicles()
	{
		$vehicleIds = $this->request()->get('selected');

		$vehiclesProcessed = $this->game()
			->player()
			->vehicles()
			->where(StolenVehicle::ATTRIBUTE_GARAGED, StolenVehicle::PLAYER_GARAGED_YES)
			->whereIn('id', $vehicleIds)
			->update([StolenVehicle::ATTRIBUTE_GARAGED => StolenVehicle::PLAYER_GARAGED_NO])
		;

		return $vehiclesProcessed;
	}

	protected function repairVehicles()
	{
		$vehicleIds = $this->request()->get('selected');

		$vehicles = $this->game()
			->player()
			->vehicles()
			->whereIn('id', $vehicleIds)
		;

		$repairCosts = 0;
		$vehicles->get()->each(function ($vehicle) use (&$repairCosts) {
			$repairCosts += ($vehicle->vehicle->value - $vehicle->value()) / 2;
		});

		$this->game()->player()->tryToTakeMoney($repairCosts);

		$vehiclesProcessed = $vehicles->update([
			StolenVehicle::ATTRIBUTE_DAMAGE => StolenVehicle::DAMAGE_NONE
		]);

		return $vehiclesProcessed;
	}
}