<?php

namespace App\Http\Controllers\Game;

use App\Game\Game;
use Illuminate\Http\Request;
use App\Http\Response\Response;
use App\Presenters\BasicPresenter;
use App\Http\Controllers\Controller as BaseController;

abstract class Controller extends BaseController
{
	protected $request, $game, $player;

	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'user.lastActive']);
    }

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

	public function player()
	{
		if (! is_null($this->player)) {
			return $this->player;
		}

		return $this->player = $this->game()->player();
	}

	public function response()
	{
		return resolve(Response::class);
	}

	public function basicPresenter()
	{
		return resolve(BasicPresenter::class);
	}
}