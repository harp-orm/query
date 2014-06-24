<?php

namespace Harp\Query\SQL;

use InvalidArgumentException;

/**
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
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
