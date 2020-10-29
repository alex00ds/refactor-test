<?php


namespace Kl;

use Kl\Interfaces\ILogger;

class Logger implements ILogger
{
    protected static $instance;

    public static function getLogger()
    {
        if (! static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function reportError($msg)
    {
        error_log($msg);
    }
}