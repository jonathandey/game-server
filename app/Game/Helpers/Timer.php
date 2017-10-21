<?php

namespace App\Game\Helpers;

use Carbon\Carbon;

class Timer
{
	protected $dateTime;

	protected $format = '%H:%I:%S';

	public function __construct($dateTime)
	{
		$this->dateTime = $dateTime;

		if (! $this->dateTime instanceof Carbon) {
			$this->dateTime = Carbon::parse($this->dateTime);
		}
	}

	public function isReady()
	{
		return $this->dateTime <= $this->now();
	}

	public function diffNow()
	{
		return $this->now()
			->diff($this->dateTime)
			->format($this->format)
		;
	}

	protected function now()
	{
		return Carbon::now();
	}
}