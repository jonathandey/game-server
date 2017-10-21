<?php

namespace App\Game\Outcomes\Punishments;

class JailTime extends Punishment
{
	protected $seconds = 0;

	public function __construct($seconds)
	{
		$this->seconds = $seconds;
	}

	public function seconds()
	{
		return $this->seconds;
	}
}