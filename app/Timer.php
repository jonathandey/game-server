<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Timer extends Model
{
	public $timestamps = false;

	protected $casts = [
		'crime' => 'timestamp',
		'auto_burglary' => 'timestamp',
	];

    //
    public function for($timerName)
    {
    	return $this->attributes[$timerName];
    }

    public function set($timerName, $seconds)
    {
    	$this->attributes[$timerName] = Carbon::now()
    		->addSeconds($seconds)
    	;

    	$this->save();

    	return $this;
    }
}
