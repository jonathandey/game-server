<?php

namespace App\Game\Helpers;

class Money
{
	protected $currencySymbol = '$';

	protected $decimalPlaces = 0;

	public function numberFormat($number)
	{
		return number_format($number, $this->decimalPlaces);
	}

	public function numberFormatWithSymbol($number)
	{
		return sprintf(
			"{$this->currencySymbol}%s", $this->numberFormat($number)
		);
	}
}