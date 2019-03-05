<?php

namespace BhuVidya\QueryLogger;

use Illuminate\Support\Facades\Facade;

class QueryLoggerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return config('query_logger.instance');
    }
}
