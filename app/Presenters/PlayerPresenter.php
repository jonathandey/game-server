<?php

namespace App\Presenters;

use App\User;
use App\Game\Helpers\Money;

class PlayerPresenter extends Presenter
{
	protected $player;

	public function __construct(User $player)
	{
		$this->player = $player;
	}

	public function money()
	{
		return (new Money)->numberFormat($this->player->{User::ATTRIBUTE_MONEY});
	}

	public function moneyWithSymbol()
	{
		return (new Money)->numberFormatWithSymbol(
			$this->player->{User::ATTRIBUTE_MONEY}
		);
	}
}