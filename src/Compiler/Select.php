<?php

namespace CL\Atlas\Compiler;

use CL\Atlas\Query;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Select
{
    /**
     * Render a Select object
     * @param  Query\Select $query
     * @return string
     */
    public static function render(Query\Select $query)
    {
        return Compiler::expression(array(
            'SELECT',
            $query->getType(),
            Aliased::combine($query->getColumns()) ?: '*',
            Compiler::word('FROM', Aliased::combine($query->getFrom())),
            Join::combine($query->getJoin()),
            Compiler::word('WHERE', Condition::combine($query->getWhere())),
            Compiler::word('GROUP BY', Direction::combine($query->getGroup())),
            Compiler::word('HAVING', Condition::combine($query->getHaving())),
            Compiler::word('ORDER BY', Direction::combine($query->getOrder())),
            Compiler::word('LIMIT', $query->getLimit()),
            Compiler::word('OFFSET', $query->getOffset()),
        ));
    }

    public static function parameters(Query\Select $query)
    {
        return Compiler::parameters(array(
            $query->getColumns(),
            $query->getFrom(),
            $query->getJoin(),
            $query->getWhere(),
            $query->getGroup(),
            $query->getHaving(),
            $query->getOrder(),
            $query->getLimit(),
            $query->getOffset(),
        ));
    }
}
