<?php

namespace App\Http\Controllers\Game;

use App\Game\Helpers\Timer;
use App\Game\Interfaces\TimerRestricted;

abstract class ActionController extends Controller
{
	protected $actionClass = null;

	public function index()
	{
		$timer = $this->timer();

		$attributes = [
			'actions' => $this->getActions(),
		];

		if (! is_null($timer) && ! $timer->isReady()) {
			$attributes['timer'] = $timer->diffNow();
		}

		return view($this->view, $attributes);
	}

    protected function action()
    {
    	return new $this->actionClass;
    }

    protected function getActions()
    {
    	$actionMethod = str_plural(
    		str_replace(
	    		'Controller', '', camel_case(class_basename(get_class($this)))
	    	)
    	);

    	return $this->game()->{$actionMethod}();
    }

    protected function timer()
    {
		if ($this->action() instanceof TimerRestricted) {
			$actionTimerAt = $this->game()
				->player()
				->timer
				->for(
					$this->action()->getTimerName()
				)
			;

			return (new Timer($actionTimerAt));
		}

		return null;
    }
}