<?php

namespace Harp\Query\SQL;

use InvalidArgumentException;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class ConditionLike extends Condition
{
    /**
     * @param string $column
     * @param mixed  $value
     */
    public function __construct($column, $value)
    {
        parent::__construct("$column LIKE ?", array($value));
    }
}
