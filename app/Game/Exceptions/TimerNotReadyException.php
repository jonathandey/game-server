<?php

namespace App\Game\Exceptions;

use App\Game\Helpers\Timer;

class TimerNotReadyException extends Exception
{
	protected $message = 'You must wait %s before attempting this again';

	public function __construct($timer, $message = null)
	{
		$this->timer = $timer;

		if (! is_null($message)) {
			$this->message = $message;
		}

		$this->message = sprintf(
			$this->message, $this->diffTimer()
		);

		parent::__construct($this->message);
	}

	protected function diffTimer()
	{
		return (new Timer($this->timer))->diffNow();
	}
}