<?php

namespace Harp\Query\SQL;

use InvalidArgumentException;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class ConditionIn extends Condition
{
    /**
     * @param string $column
     * @param array  $value
     */
    public function __construct($column, array $value)
    {
        if (empty($value)) {
            throw new InvalidArgumentException('Values must not be empty array');
        }

        parent::__construct("$column IN ?", array($value));
    }
}
