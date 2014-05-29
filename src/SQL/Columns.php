<?php

namespace Luna\Query\SQL;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Columns extends SQL
{
    protected $columns;

    public function __construct(array $columns)
    {
        $this->columns = $columns;
    }

    public function all()
    {
        return $this->columns;
    }
}
