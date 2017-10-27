<?php

namespace App\Http\Controllers\Traits;

trait HasModelContext
{
	public function model()
	{
		return app($this->modelClass);
	}
}