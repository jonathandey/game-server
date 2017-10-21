<?php

namespace App\Game\Interfaces;

interface TimerRestricted
{
	public function getTimerName();

	public function getTimerDuration();
}