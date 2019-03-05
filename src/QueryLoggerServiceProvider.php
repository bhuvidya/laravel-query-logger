<?php

namespace BhuVidya\QueryLogger;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class QueryLoggerServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        // config file
        if ($this->app->runningInConsole()) {
            $source = realpath(__DIR__.'/../config/query_logger.php');
            $this->publishes([$source => config_path('query_logger.php')], 'config');
        }

        $logger = app(config('query_logger.instance'));

        if ($logger->isActive()) {
            DB::listen(function (QueryExecuted $query) use ($logger) {
                $logger->log($query);
            });
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $source = realpath(__DIR__.'/../config/query_logger.php');
        $this->mergeConfigFrom($source, 'query_logger');

        $this->app->singleton(config('query_logger.instance'), function () {
            return new QueryLogger();
        });

        if ($cls = config('query_logger.facade')) {
            AliasLoader::getInstance()->alias($cls, QueryLoggerFacade::class);
        }
    }
}
