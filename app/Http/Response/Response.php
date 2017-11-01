<?php

namespace App\Http\Response;

class Response
{
	public function redirectBackWithMessage($message)
	{
		return redirect()->back()->with(compact('message'));
	}
}