<?php

namespace App\Http\Controllers\Game;

use Hash;
use App\Http\Requests\UpdateProfileQuote;
use App\Http\Requests\UpdateAccountPassword;

class EditUserProfileController extends Controller
{
	public function index()
	{
		$player = $this->player();

		return $this->response()->view('game.user.profile', compact('player'));
	}

	public function updateQuote(UpdateProfileQuote $request)
	{
		$quote = $this->request()->get('quote');

		$this->player()->quote = e($quote);
		$this->player()->save();

		$profileUrl = $this->player()->presenter()->profileUrl();
		$this->message(
			$this->basicPresenter()->htmlSuccessMessage(
				"Your profile quote has been updated. <a href='{$profileUrl}'>View it now</a>"
			)
		);

		return $this->response()->redirectBackWithMessage($this->message());
	}

	public function updatePassword(UpdateAccountPassword $request)
	{
		$currentPassword = $this->request()->get('current_password');

		if (! Hash::check($currentPassword, $this->player()->password)) {
			$this->message(
				$this->basicPresenter()->htmlErrorMessage(
					'Your current password is incorrect'
				)
			);

			return $this->response()->redirectBackWithMessage($this->message());
		}

		$newPassword = Hash::make(
			$this->request()->get('new_password')
		);

		$this->player()->password = $newPassword;
		$this->player()->save();

		$this->message(
			$this->basicPresenter()->htmlSuccessMessage(
				'Your password has been updated'
			)
		);

		return $this->response()->redirectBackWithMessage($this->message());
	}
} 