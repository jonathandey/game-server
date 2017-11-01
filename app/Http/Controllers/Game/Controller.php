<?php

namespace App\Http\Controllers\Game;

use App\Game\Game;
use Illuminate\Http\Request;
use App\Http\Response\Response;
use App\Presenters\BasicPresenter;
use App\Http\Controllers\Controller as BaseController;

abstract class Controller extends BaseController
{
	protected $request, $response, $game, $player, $message;

	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'user.lastActive']);

        $this->message = null;
    }

	public function message($message = null)
	{
		if (! is_null($this->message)) {
			return $this->message;
		}

		$this->message = $message;

		return $this;
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
		if (! is_null($this->response)) {
			return $this->response;
		}

		return $this->response = resolve(Response::class);
	}

	public function basicPresenter()
	{
		return resolve(BasicPresenter::class);
	}
}