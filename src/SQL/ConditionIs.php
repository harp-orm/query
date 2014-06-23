<?php

namespace Harp\Query\SQL;

use InvalidArgumentException;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class ConditionIs extends Condition
{
    /**
     * @param string $column
     * @param mixed  $value
     */
    public function __construct($column, $value)
    {
        if (is_array($value)) {
            throw new InvalidArgumentException('Use ConditionIn for array conditions');
        }

        if ($value === null) {
            parent::__construct("$column IS NULL");
        } else {
            parent::__construct("$column = ?", array($value));
        }
    }
}
