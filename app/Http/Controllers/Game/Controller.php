<?php

namespace App\Http\Controllers\Game;

use App\Game\Game;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

abstract class Controller extends BaseController
{
	protected $request, $game;

	public function request()
	{
		if (! is_null($this->request)) {
			return $this->request;
		}

		return $this->request = resolve(Request::class);
	}

	public function game()
	{
		if (! is_null($this->game)) {
			return $this->game;
		}

		return $this->game = resolve(Game::class);
	}
}