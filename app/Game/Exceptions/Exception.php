<?php

namespace App\Game\Exceptions;

use Exception as BaseException;

abstract class Exception extends BaseException
{
	protected $message = 'A badly worded exception occurred';

	public function __construct(string $message = null)
	{
		if (! is_null($message)) {
			$this->message = $message;
		}
	}
}