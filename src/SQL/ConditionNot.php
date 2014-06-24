<?php

namespace Harp\Query\SQL;

use InvalidArgumentException;

/**
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class ConditionNot extends Condition
{
    /**
     * @param string $column
     * @param mixed  $value
     */
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
