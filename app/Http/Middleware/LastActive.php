<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use App\Game\Game;

class LastActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $player = app(Game::class)->player();

        if (! is_null($player)) {
            $player->updateActiveTime();
        }

        return $next($request);
    }
}
