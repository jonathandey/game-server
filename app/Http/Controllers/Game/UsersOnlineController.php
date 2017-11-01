<?php

namespace App\Http\Controllers\Game;

use App\Game\Game;

class UsersOnlineController extends Controller
{
	public function index()
	{
		// Todo: shuffle
		$onlineUsers = app(Game::class)->usersOnline();

		return $this->response()->view('game.information.users_online', compact('onlineUsers'));
	}
}