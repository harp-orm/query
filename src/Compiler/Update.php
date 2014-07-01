<?php

namespace Harp\Query\Compiler;

use Harp\Query;

/**
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class Update
{
    /**
     * Render Update object
     * @param  Query\Update $query
     * @return string
     */
    public static function render(Query\Update $query)
    {
        return Compiler::withDb($query->getDb(), function () use ($query) {
            return Compiler::expression(array(
                'UPDATE',
                $query->getType(),
                Aliased::combine($query->getTable()),
                Join::combine($query->getJoin()),
                Compiler::word('SET', Set::combine($query->getSet())),
                Compiler::word('WHERE', Condition::combine($query->getWhere())),
                Compiler::word('ORDER BY', Direction::combine($query->getOrder())),
                Compiler::word('LIMIT', $query->getLimit()),
            ));
        });
    }

    /**
     * @param  Query\Update $query
     * @return array
     */
    public static function parameters(Query\Update $query)
    {
        return Compiler::parameters(array(
            $query->getTable(),
            $query->getJoin(),
            $query->getSet(),
            $query->getWhere(),
            $query->getOrder(),
            $query->getLimit(),
        ));
    }
}
