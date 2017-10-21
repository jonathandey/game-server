<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActionOffset extends Model
{
	const ATTRIBUTE_CRIMES = 'crimes';

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function scopeFor($query, $column)
	{
		$query->pluck($column);
	}
}