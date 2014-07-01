<?php

namespace Harp\Query\SQL;

/**
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class ConditionLike extends Condition
{
    /**
     * @param string $column
     * @param mixed  $value
     */
    public function __construct($column, $value)
    {
        parent::__construct($column, "LIKE ?", array($value));
    }
}
