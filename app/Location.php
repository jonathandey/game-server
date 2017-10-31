<?php

namespace App;

use App\StolenVehicle;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
	public function players()
	{
		return $this->hasMany(User::class);
	}

	public function parkedVehicles()
	{
		return $this->hasMany(StolenVehicle::class, 'location');
	}

	public function stolenVehicles()
	{
		return $this->hasMany(StolenVehicle::class, 'origin_location');
	}
}
