<?php

namespace App\Presenters;

use App\Game\Player;
use App\Game\Helpers\Money;

class PlayerPresenter extends Presenter
{
	protected $player;

	public function __construct(Player $player)
	{
		$this->player = $player;
	}

	public function money()
	{
		return (new Money)->numberFormat($this->player->{Player::ATTRIBUTE_MONEY});
	}

	public function moneyWithSymbol()
	{
		return (new Money)->numberFormatWithSymbol(
			$this->player->{Player::ATTRIBUTE_MONEY}
		);
	}

	public function presence()
	{
		if ($this->player->presenceStatus() == Player::PRESENCE_STATUS_IDLE) {
			return 'idle';
		}

		if ($this->player->presenceStatus() == Player::PRESENCE_STATUS_ONLINE) {
			return 'online';
		}

		return 'offline';
	}
}