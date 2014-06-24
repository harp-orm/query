<?php

namespace Harp\Query\SQL;

use Harp\Query\Arr;

/**
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class SetMultiple extends Set
{
    /**
     * @param string $column
     * @param array  $values
     * @param string $key
     */
    public function __construct($column, array $values, $key = 'id')
    {
        $cases = str_repeat('WHEN ? THEN ? ', count($values));

        parent::__construct(
            $column,
            new SQL(
                "CASE {$key} {$cases}ELSE $column END",
                Arr::disassociate($values)
            )
        );
    }
}
