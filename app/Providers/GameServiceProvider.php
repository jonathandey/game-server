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

        $this->app['App\Game\Game']->crimes([
            [
                'name' => 'Pick Pocket a Passerby',
                'minPayout' => 10.0,
                'maxPayout' => 30.0,
                'difficulty' => .7,
                'messages' => [
                    'successful' => 'You successfully commited the crime.',
                    'failed' => 'You were unsuccessful commiting this crime',
                ],
            ],
            [
                'name' => 'Steal from Betty\'s Clothing',
                'minPayout' => 29.0,
                'maxPayout' => 36.0,
                'difficulty' => 2.6,
                'messages' => [
                    'successful' => 'You successfully commited the crime.',
                    'failed' => 'You were unsuccessful commiting this crime',
                ],
            ],
            [
                'name' => 'Steal from Frank\'s Garage',
                'minPayout' => 34.0,
                'maxPayout' => 53.0,
                'difficulty' => 4.8,
                'messages' => [
                    'successful' => 'You successfully commited the crime.',
                    'failed' => 'You were unsuccessful commiting this crime',
                ],
            ],
            [
                'name' => 'Steal from Jimmy\'s Liquor Store',
                'minPayout' => 55.0,
                'maxPayout' => 72.0,
                'difficulty' => 6.5,
                'messages' => [
                    'successful' => 'You successfully commited the crime.',
                    'failed' => 'You were unsuccessful commiting this crime',
                ],
            ],
            [
                'name' => 'Steal from Young\'s Manufacturing',
                'minPayout' => 80.0,
                'maxPayout' => 110.0,
                'difficulty' => 8,
                'messages' => [
                    'successful' => 'You successfully commited the crime.',
                    'failed' => 'You were unsuccessful commiting this crime',
                ],
            ],
            [
                'name' => 'Rob the Jones Bank',
                'minPayout' => 85.0,
                'maxPayout' => 130.0,
                'difficulty' => 12,
                'messages' => [
                    'successful' => 'You successfully commited the crime.',
                    'failed' => 'You were unsuccessful commiting this crime',
                ],
            ],
        ]);

        $this->app['App\Game\Game']->dice(new Dice);

        Blade::directive('timer', function ($expression) {
            return "<?php echo (new \App\Game\Helpers\Timer($expression))->diffNow(); ?>";
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
