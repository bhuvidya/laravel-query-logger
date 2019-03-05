<?php

namespace BhuVidya\QueryLogger;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Log;

class QueryLogger
{
    private $on;
    private $env;
    private $query_param;
    private $all;

    private $min_time_ms;

    private $log;
    private $log_level;
    private $log_channel;
    private $log_stack;
    private $log_prefix;

    private $dump_server;

    private $active = false;
    private $logging = false;
    private $log_cnt = 0;

    /**
     * Ctor.
     */
    public function __construct()
    {
        $config = config('query_logger');

        $this->on = $config['on'];
        $this->env = $config['env'];
        $this->query_param = $config['query_param'];
        $this->all = $config['all'];

        $this->min_time_ms = $config['min_time_ms'];

        $logging = $config['log'];
        $this->log = $logging['on'];
        $this->log_level = $logging['level'];
        $this->log_channel = $logging['channel'];
        $this->log_stack = $logging['stack'];
        $this->log_prefix = $logging['prefix'];

        $this->dump_server = $config['dump_server'];

        $this->active = $this->isActive();
        $this->logging = false;
    }

    /**
     * Check if our logger should be on or not.
     *
     * @return bool
     */
    public function isActive()
    {
        if (!$this->haveAtLeastOneEmitMethod()) {
            return false;
        }

        if ($this->query_param && (bool) request()->input($this->query_param)) {
            return true;
        }

        if (!$this->on) {
            return false;
        }

        if (!$this->env || in_array(app()->environment(), $this->env)) {
            return true;
        }

        return false;
    }

    /**
     * Do we have at least one emit method? Log? Dump server?
     *
     * @return bool
     */
    public function haveAtLeastOneEmitMethod()
    {
        return ($this->log && ($this->log_channel || $this->log_stack)) || $this->dump_server;
    }

    /**
     * Start logging.
     *
     * @param string $msg - optional
     */
    public function startLogging($msg = null)
    {
        $this->logging = true;

        if ($msg) {
            $this->startLoggingMessage();
            $this->logString($msg);
        }
    }

    /**
     * End logging.
     *
     * @param string $msg - optional
     */
    public function endLogging($msg = null)
    {
        if ($msg) {
            $this->logString($msg);
        }

        $this->logging = false;
    }

    /**
     * Is logging?
     *
     * @return bool
     */
    public function isLogging()
    {
        return $this->logging;
    }

    /**
     * Log the database query.
     *
     * @param Illuminate\Database\Events\QueryExecuted $query
     *
     * @return bool
     */
    public function log(QueryExecuted $query)
    {
        if (!$this->active) {
            return false;
        }
        if (!$this->all && !$this->logging) {
            return false;
        }

        if ($this->min_time_ms > 0 && $query->time < $this->min_time_ms) {
            return false;
        }

        $this->startLoggingMessage();

        $sqlWithPlaceholders = str_replace(['%', '?'], ['%%', '%s'], $query->sql);

        $bindings = $query->connection->prepareBindings($query->bindings);
        $pdo = $query->connection->getPdo();
        $realSql = vsprintf($sqlWithPlaceholders, array_map([$pdo, 'quote'], $bindings));
        $duration = $this->formatDuration($query->time / 1000);
        $output = sprintf('%s[%s] %s', $this->log_prefix ? "{$this->log_prefix} " : '', $duration, $realSql);

        $this->logString($output);

        $this->log_cnt++;

        return true;
    }

    /**
     * Emit a mesage to denote start of all logging for the request.
     */
    private function startLoggingMessage()
    {
        if ($this->log_cnt > 0) {
            return;
        }

        $this->logString(sprintf('============ %s: %s ===============', request()->method(), request()->fullUrl()));
    }

    /**
     * Log a simple string.
     *
     * @param string $str
     *
     * @return bool
     */
    private function logString($str)
    {
        if (!$this->active) {
            return false;
        }
        if (!$this->all && !$this->logging) {
            return false;
        }

        if ($this->log && ($this->log_channel || $this->log_stack)) {
            $logger = $this->log_stack ? Log::stack($this->log_stack) : Log::channel($this->log_channel);
            $logger->{$this->log_level}($str);
        }

        if ($this->dump_server) {
            dump($str);
        }

        return true;
    }

    /**
     * Format duration.
     *
     * @param float $seconds
     *
     * @return string
     */
    private function formatDuration($seconds)
    {
        if ($seconds < 0.001) {
            return round($seconds * 1000000).'μs';
        }

        if ($seconds < 1) {
            return round($seconds * 1000, 2).'ms';
        }

        return round($seconds, 2).'s';
    }
}
