<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class DatabaseServiceProvider extends ServiceProvider
{
    /**
     * Environment database url variable.
     *
     * @var string
     */
    protected $variable = 'CLEARDB_DATABASE_URL';

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $host = $this->fetchFromDatabaseUrl('host');
        $username = $this->fetchFromDatabaseUrl('user');
        $password = $this->fetchFromDatabaseUrl('pass');
        $database = $this->fetchDatabaseFromDatabaseUrl();

        $this->app->config->set(array_filter([
            'database.connections.mysql.host' => $host,
            'database.connections.mysql.database' => $database,
            'database.connections.mysql.username' => $username,
            'database.connections.mysql.password' => $password,
        ]));
    }

    /**
     * Fetch the database name from the database url.
     *
     * @return string|null
     */
    protected function fetchDatabaseFromDatabaseUrl()
    {
        if ($this->fetchFromDatabaseUrl('path')) {
            return substr($this->fetchFromDatabaseUrl('path'), 1);
        }
    }

    /**
     * Fetch a single data from the database url.
     *
     * @param  string $key
     * @param  mixed  $default
     *
     * @return mixed|null
     */
    protected function fetchFromDatabaseUrl($key, $default = null)
    {
        return array_get(parse_url(env($this->variable)), $key, $default);
    }
}
