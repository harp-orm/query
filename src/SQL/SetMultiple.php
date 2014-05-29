<?php

namespace Harp\Query\SQL;

use Harp\Query\Arr;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class SetMultiple extends Set
{
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
