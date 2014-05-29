<?php

namespace Luna\Query\SQL;

use InvalidArgumentException;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class ConditionNot extends Condition
{
    public function __construct($column, $value)
    {
        if (is_array($value)) {
            throw new InvalidArgumentException('Use ConditionNot for array conditions');
        }

        if ($value === null) {
            parent::__construct("$column IS NOT NULL");
        } else {
            parent::__construct("$column != ?", array($value));
        }

    }
}
