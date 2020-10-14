<?php

namespace Starfolksoftware\PasswordHistory;

use Illuminate\Support\ServiceProvider;
use Starfolksoftware\PasswordHistory\Commands\PasswordHistoryCommand;

class PasswordHistoryServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/password-history.php' => config_path('password-history.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../resources/views' => base_path('resources/views/vendor/password-history'),
            ], 'views');

            $migrationFileName = 'create_password_histories_table.php';
            if (! $this->migrationFileExists($migrationFileName)) {
                $this->publishes([
                    __DIR__ . "/../database/migrations/{$migrationFileName}.stub" => database_path('migrations/' . date('Y_m_d_His', time()) . '_' . $migrationFileName),
                ], 'migrations');
            }

            $this->commands([
                PasswordHistoryCommand::class,
            ]);
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'password-history');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/password-history.php', 'password-history');
    }

    public static function migrationFileExists(string $migrationFileName): bool
    {
        $len = strlen($migrationFileName);
        foreach (glob(database_path("migrations/*.php")) as $filename) {
            if ((substr($filename, -$len) === $migrationFileName)) {
                return true;
            }
        }

        return false;
    }
}
