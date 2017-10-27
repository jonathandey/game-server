<?php

namespace App\Http\Controllers\Game;

use App\Game\Game;

class UsersOnlineController extends Controller
{
	public function index()
	{
		// shuffle
		$onlineUsers = app(\App\Game\Game::class)->usersOnline();

		return view('game.information.users_online', compact('onlineUsers'));
	}
}