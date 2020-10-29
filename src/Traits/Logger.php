<?php

namespace Kl\Traits;

use Kl\Interfaces\ILogger;
use Kl\Logger as DefaultLogger;

trait Logger
{
    private $logger;

    public function setLogger(ILogger $logger)
    {
        $this->logger = $logger;
    }

    public function getLogger()
    {
        if (!$this->logger) {
            $this->setLogger(DefaultLogger::getLogger());
        }

        return $this->logger;
    }
}