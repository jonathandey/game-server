<?php

namespace App\Game\Exceptions;

class NotEnoughMoneyException extends Exception
{
	protected $message = 'You do not have enough money to do this';
}