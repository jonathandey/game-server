<?php

namespace App\Game\Actions\Travel;

use App\Game\Actions\Action;
use App\Game\Traits\HasTimer;
use App\Presenters\Presentable;
use App\Game\Actions\Actionable;
use App\Presenters\TransportPresenter;
use App\Game\Interfaces\TimerRestricted;

abstract class Transport extends Action implements Actionable, TimerRestricted
{
	use HasTimer, Presentable;

	protected $presenter = TransportPresenter::class;

	protected $timerName = 'train';
}