<?php

namespace App;

use Hash;
use App\Game\Player;

class User extends Player
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function actionOffset()
    {
        return $this->hasOne(ActionOffset::class);
    }
}
