<?php

namespace Harp\Query\SQL;

use Harp\Query\Parametrised;

/**
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class Direction extends SQL
{
    /**
     * @var string
     */
    protected $direction;

    /**
     * @param string|SQL $column
     * @param string $direction
     */
    public function __construct($column, $direction = null)
    {
        parent::__construct($column);

        $this->direction = $direction;
    }

    public function getParameters()
    {
        if ($this->getContent() instanceof Parametrised) {
            return $this->getContent()->getParameters();
        }
    }

    /**
     * @return string
     */
    public function getDirection()
    {
        return $this->direction;
    }
}
