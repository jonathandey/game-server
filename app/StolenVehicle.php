<?php

namespace App;

use App\Game\Game;
use App\Presenters\Presentable;
use App\Game\Items\Vehicles\Vehicle;
use Illuminate\Database\Eloquent\Model;
use App\Presenters\StolenVehiclePresenter;

class StolenVehicle extends Model
{
	use Presentable;

	const ATTRIBUTE_DAMAGE = 'damage';

	const ATTRIBUTE_DROPPED = 'dropped';

    const ATTRIBUTE_SOLD = 'sold';

	const ATTRIBUTE_GARAGED = 'garaged';

    const ATTRIBUTE_ORIGIN_LOCATION_ID = 'origin_location';

    const ATTRIBUTE_LOCATION_ID = 'location';

	const PLAYER_SOLD_YES = 1;

	const PLAYER_SOLD_NO = 0;

    const PLAYER_DROPPED_YES = 1;

    const PLAYER_DROPPED_NO = 0;

    const PLAYER_GARAGED_YES = 1;

	const PLAYER_GARAGED_NO = 0;

    const DAMAGE_NONE = 0;

    const DAMAGE_FULL = 50;

	public $table = 'stolen_vehicles';

	protected $casts = [
		'dropped',
		'sold',
		'garaged',
	];

	protected $appends = [
		'value',
	];

    protected $presenter = StolenVehiclePresenter::class;

    //
    public function owner()
    {
    	return $this->belongsTo(User::class);
    }

    public function vehicle()
    {
    	return $this->belongsTo(Vehicle::class);
    }

   	public function getValueAttribute()
    {
    	return $this->value();
    }

    public function value()
    {
    	$vehicleValue = $this->vehicle->value;
    	return $vehicleValue - (($vehicleValue * $this->damage / 100) * 2);
    }

    public function giveDamage()
    {
		$this->attributes[self::ATTRIBUTE_DAMAGE] = app(Game::class)
    		->dice()
    		->roll(self::DAMAGE_NONE, self::DAMAGE_FULL)
    	;   	
    }

    public function isGaraged()
    {
        return $this->garaged;
    }

    public function stolenFrom()
    {
        return $this->belongsTo(Location::class, self::ATTRIBUTE_ORIGIN_LOCATION_ID);
    }

    public function parkedAt()
    {
        return $this->belongsTo(Location::class, self::ATTRIBUTE_LOCATION_ID);
    }
}
