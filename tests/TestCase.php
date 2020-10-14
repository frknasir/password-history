<?php

namespace StarfolkSoftware\PasswordHistory\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use StarfolkSoftware\PasswordHistory\PasswordHistoryServiceProvider;
use Illuminate\Database\Schema\Blueprint;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();
        $this->loadLaravelMigrations(['--database' => 'sqlite']);
        $this->setUpDatabase();
    }

    protected function getPackageProviders($app)
    {
        return [
            PasswordHistoryServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('auth.providers.users.model', User::class);
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $app['config']->set('app.key', 'base64:6Cu/ozj4gPtIjmXjr8EdVnGFNsdRqZfHfVjQkmTlg4Y=');
        /*
        include_once __DIR__.'/../database/migrations/create_password_histories_table.php.stub';
        (new \CreatePackageTable())->up();
        */
    }

    protected function setUpDatabase() {
        include_once __DIR__ . '/../database/migrations/create_password_histories_table.php.stub';
        
        (new \CreatePasswordHistoriesTable())->up();
    }
}
