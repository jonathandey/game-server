<?php

namespace App;

use App\Presenters\Presentable;
use Illuminate\Database\Eloquent\Model;
use App\Presenters\BoxingMatchPresenter;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoxingMatch extends Model
{
	use SoftDeletes, Presentable;

	const ATTRIBUTE_MONETARY_STAKE = 'monetary_stake';

	const ATTRIBUTE_VICTOR_USER_ID = 'victor_user_id';

    const ATTRIBUTE_DRAW = 'draw';

	protected $presenter = BoxingMatchPresenter::class;

    protected $fillable = [
    	'monetary_stake',
    	'taunt',
    ];

    protected $casts = [
        self::ATTRIBUTE_DRAW => 'boolean',
    ];

    public function originator()
    {
    	return $this->belongsTo(User::class, 'originator_user_id');
    }

    public function challenger()
    {
    	return $this->belongsTo(User::class, 'challenger_user_id');
    }

    public function victor()
    {
    	return $this->belongsTo(User::class, 'victor_user_id');	
    }

    public function scopeActive($query)
    {
    	$query->whereNull(self::ATTRIBUTE_VICTOR_USER_ID)
            ->where(self::ATTRIBUTE_DRAW, false)
        ;
    }
}
