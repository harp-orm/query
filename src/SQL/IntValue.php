<?php

namespace Harp\Query\SQL;

/**
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class IntValue extends SQL
{
    /**
     * @param integer $value
     */
    public function __construct($value)
    {
        parent::__construct((string) (int) $value);
    }
}
