<?php

namespace CL\Atlas\Test;

use Psr\Log\AbstractLogger;

/**
 * A dummy logger used for testing
 */
class TestLogger extends AbstractLogger
{
    /**
     * @var array
     */
    protected $entries = array();

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return null
     */
    public function log($level, $message, array $context = array())
    {
        $this->entries []= [$level, $message, $context];
    }

    /**
     * @return array
     */
    public function getEntries()
    {
        return $this->entries;
    }
}
