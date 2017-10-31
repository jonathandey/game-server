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

        $this->setWealthStatuses();

        $this->setTravelDestinations();

        $this->registerDice();

        $this->extendBlade();
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

    protected function registerDice()
    {
        $this->app['App\Game\Game']->dice(new Dice);
    }

    protected function setTravelDestinations()
    {
        $this->app['App\Game\Game']->travelDestinations([
            // From NJ to X
            [
                'from' => 1,
                'to' => 1,
                'distance' => 0,
            ],
            [
                'from' => 1,
                'to' => 2,
                'distance' => 1,
            ],
            [
                'from' => 1,
                'to' => 3,
                'distance' => 2,
            ],
            [
                'from' => 1,
                'to' => 4,
                'distance' => 6,
            ],
            // From New York to X
            [
                'from' => 2,
                'to' => 2,
                'distance' => 0,
            ],
            [
                'from' => 2,
                'to' => 1,
                'distance' => 1,
            ],
            [
                'from' => 2,
                'to' => 3,
                'distance' => 2,
            ],
            [
                'from' => 2,
                'to' => 4,
                'distance' => 6,
            ],
            // From Illinois to X
            [
                'from' => 3,
                'to' => 3,
                'distance' => 0,
            ],
            [
                'from' => 3,
                'to' => 1,
                'distance' => 2,
            ],
            [
                'from' => 3,
                'to' => 2,
                'distance' => 1,
            ],
            [
                'from' => 3,
                'to' => 4,
                'distance' => 4,
            ],
            // From Cali to X
            [
                'from' => 4,
                'to' => 4,
                'distance' => 0,
            ],
            [
                'from' => 4,
                'to' => 1,
                'distance' => 6,
            ],
            [
                'from' => 4,
                'to' => 2,
                'distance' => 5,
            ],
            [
                'from' => 4,
                'to' => 3,
                'distance' => 4,
            ],
        ]);
    }

    protected function setWealthStatuses()
    {
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
    }

    protected function extendBlade()
    {
        Blade::directive('timer', function ($expression) {
            return "<?php echo (new \App\Game\Helpers\Timer($expression))->diffNow(); ?>";
        });

        Blade::directive('money', function ($expression) {
            return "<?php echo (new App\Game\Helpers\Money)->numberFormatWithSymbol($expression); ?>";
        });
    }
}
