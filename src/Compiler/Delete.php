<?php

namespace CL\Atlas\Compiler;

use CL\Atlas\Query;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Delete
{
    /**
     * Render a Delete object
     * @param  Query\Delete $query
     * @return string
     */
    public static function render(Query\Delete $query)
    {
        return Compiler::expression(array(
            'DELETE',
            $query->getType(),
            Aliased::combine($query->getTable()),
            Compiler::word('FROM', Aliased::combine($query->getFrom())),
            Join::combine($query->getJoin()),
            Compiler::word('WHERE', Condition::combine($query->getWhere())),
            Compiler::word('ORDER BY', Direction::combine($query->getOrder())),
            Compiler::word('LIMIT', $query->getLimit()),
        ));
    }

    public static function parameters(Query\Delete $query)
    {
        return Compiler::parameters(array(
            $query->getTable(),
            $query->getFrom(),
            $query->getJoin(),
            $query->getWhere(),
            $query->getOrder(),
            $query->getLimit(),
        ));
    }
}
