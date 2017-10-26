<?php

namespace App\Http\Controllers\Game;

use Carbon\Carbon;

class NotificationsController extends Controller
{
	const PAGINATION_LIMIT = 15;

	public function index()
	{
		$playerNotifications = $this->player()
			->notifications()
		;

		$notifications = $playerNotifications->paginate(self::PAGINATION_LIMIT);

		$notifications->getCollection()->markAsRead();

		return view('game.information.notifications', compact('notifications'));
	}
}