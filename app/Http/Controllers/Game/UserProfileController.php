<?php

namespace App\Http\Controllers\Game;

use App\User;

class UserProfileController extends Controller
{
	public function index($userId)
	{
		try {
			$user = User::findOrFail($userId);
		} catch (ModelNotFoundException $e) {
			return "user not found";
		}

		return view('game.profile.user', compact('user'));
	}
}