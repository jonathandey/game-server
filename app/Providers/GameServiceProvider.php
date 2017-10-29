<?php

namespace App\Providers;

use App\Game\Game;
use App\Game\Dice;
use App\Game\Helpers\Timer;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use App\Game\Items\Vehicles\Vehicle;
use App\Game\Actions\Crimes\AutoBurglary;
use Illuminate\Support\Facades\Schema;

class GameServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->app->bind('App\Game\Game', function() {
            return Game::instance();
        });

        $this->app['App\Game\Game']->dice(new Dice);

        Blade::directive('timer', function ($expression) {
            return "<?php echo (new \App\Game\Helpers\Timer($expression))->diffNow(); ?>";
        });

        Blade::directive('money', function ($expression) {
            return "<?php echo (new App\Game\Helpers\Money)->numberFormatWithSymbol($expression); ?>";
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
