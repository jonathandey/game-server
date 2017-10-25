<?php

namespace App\Presenters;

use App\Game\Game;
use App\BoxingMatch;
use App\Game\Helpers\Money;

class BoxingMatchPresenter extends Presenter
{
	protected $boxingMatch, $game;

	public function __construct(BoxingMatch $boxingMatch)
	{
		$this->boxingMatch = $boxingMatch;

		$this->game = app(Game::class);
	}

	public function originator()
	{
		return $this->boxingMatch->originator->name;
	}

	public function taunt()
	{
		return '"' . $this->boxingMatch->taunt . '"';
	}

	public function hasTaunt()
	{
		return ! is_null($this->boxingMatch->taunt);
	}

	public function monetaryStake()
	{
		return (new Money)->numberFormat(
			$this->boxingMatch->{BoxingMatch::ATTRIBUTE_MONETARY_STAKE}
		);
	}

	public function monetaryStakeWithSymbol()
	{
		return (new Money)->numberFormatWithSymbol(
			$this->boxingMatch->{BoxingMatch::ATTRIBUTE_MONETARY_STAKE}
		);
	}

	public function isPlayersMatch()
	{
		return $this->boxingMatch->originator->getKey() ==
			$this->game->player()->getKey();
	}
}