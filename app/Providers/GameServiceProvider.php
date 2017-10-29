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

        $this->app['App\Game\Game']->wealthStatuses([
            [
                'name' => 'Poor',
                'min' => 0,
                'max' => 500,
            ],
            [
                'name' => 'Solvent',
                'min' => 501,
                'max' => 9999,
            ],
            [
                'name' => 'Working Class',
                'min' => 10000,
                'max' => 59999,
            ],
            [
                'name' => 'Lower Class',
                'min' => 60000,
                'max' => 119999,
            ],
            [
                'name' => 'Middle Class',
                'min' => 120000,
                'max' => 299999,
            ],
            [
                'name' => 'Upper Class',
                'min' => 300000,
                'max' => 999999,
            ],
            [
                'name' => 'Millionaire',
                'min' => 1000000,
                'max' => 2999999,
            ],
            [
                'name' => 'Multi-Millionaire',
                'min' => 3000000,
                'max' => 9999999,
            ],
            [
                'name' => 'Affluent',
                'min' => 10000000,
                'max' => 49999999,
            ],
            [
                'name' => 'Excessively Rich',
                'min' => 50000000,
                'max' => 99999999,
            ],
            [
                'name' => 'Dangerously Rich',
                'min' => 100000000,
                'max' => 999999999999,
            ],
        ]);

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
