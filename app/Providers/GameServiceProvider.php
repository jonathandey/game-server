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
                'name' => 'Pick Pocket Someone',
                'minPayout' => 10.0,
                'maxPayout' => 30.0,
                'difficulty' => .7,
                'messages' => [
                    'successful' => 'You successfully commited the crime.',
                    'failed' => 'You were unsuccessful commiting this crime',
                ],
            ],
            [
                'name' => 'Steal from a Store',
                'minPayout' => 30.0,
                'maxPayout' => 80.0,
                'difficulty' => 1.5,
                'messages' => [
                    'successful' => 'You successfully commited the crime.',
                    'failed' => 'You were unsuccessful commiting this crime',
                ],
            ],
            [
                'name' => 'Rob a Bank',
                'minPayout' => 85.0,
                'maxPayout' => 130.0,
                'difficulty' => 9.0,
                'messages' => [
                    'successful' => 'You successfully commited the crime.',
                    'failed' => 'You were unsuccessful commiting this crime',
                ],
            ],
        ]);

        if (Schema::hasTable((new Vehicle)->getTable())) {
            $this->app['App\Game\Game']->vehicles(Vehicle::get());
        }

        if (Schema::hasTable((new AutoBurglary)->getTable())) {
            $this->app['App\Game\Game']->autoBurglaries(AutoBurglary::get());
        }

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
