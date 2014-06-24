<?php

namespace Harp\Query\SQL;

/**
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class Values extends SQL
{
    public function __construct(array $values)
    {
        parent::__construct(null, $values);
    }
}
