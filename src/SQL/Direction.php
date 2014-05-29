<?php

namespace Harp\Query\SQL;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Direction extends SQL
{
    protected $direction;

    public function __construct($column, $direction = null)
    {
        parent::__construct($column);

        $this->direction = $direction;
    }

    public function getDirection()
    {
        return $this->direction;
    }
}
