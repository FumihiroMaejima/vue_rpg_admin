<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Log;

class QueryLogHandler
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  illuminate.query  $event
     * @return void
     */
    public function handle($query, $bindings)
    {
        if (Config::get('app.debug')) {
            Log::info(__CLASS__ . '::' . __FUNCTION__ . ' line:' . __LINE__ . ' ' . 'log test message.');
            Log::debug('EXECUTE SQL:[' . $query . ']', ['BINDINGS' => json_encode($bindings)]);
        }
    }
}
