<?php

namespace App\Providers;
use App\Auth\Passwords\PasswordBroker;
use Illuminate\Support\ServiceProvider;

class PasswordResetServiceProvider extends \Illuminate\Auth\Passwords\PasswordResetServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    protected function registerPasswordBroker()
    {
        $this->app->singleton('auth.password', function ($app) {
            $tokens = $app['auth.password.tokens'];

            $users = $app['auth']->driver()->getProvider();

            $view = $app['config']['auth.password.email'];

            return new PasswordBroker(
                $tokens, $users, $app['mailer'], $view
            );
        });
    }
}
