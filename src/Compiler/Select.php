<?php

namespace CL\Atlas\Compiler;

use CL\Atlas\Query;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Select extends Compiler
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
            $query->getChild(Query\AbstractQuery::TYPE),
            Aliased::combine($query->getChild(Query\AbstractQuery::COLUMNS)) ?: '*',
            Compiler::word(
                'FROM',
                Aliased::combine($query->getChild(Query\AbstractQuery::FROM))
            ),
            Join::combine(
                $query->getChild(Query\AbstractQuery::JOIN)
            ),
            Compiler::word(
                'WHERE',
                Condition::combine(
                    $query->getChild(Query\AbstractQuery::WHERE)
                )
            ),
            Compiler::word(
                'GROUP BY',
                Direction::combine(
                    $query->getChild(Query\AbstractQuery::GROUP_BY)
                )
            ),
            Compiler::word(
                'HAVING',
                Condition::combine(
                    $query->getChild(Query\AbstractQuery::HAVING)
                )
            ),
            Compiler::word(
                'ORDER BY',
                Direction::combine(
                    $query->getChild(Query\AbstractQuery::ORDER_BY)
                )
            ),
            Compiler::word(
                'LIMIT',
                $query->getChild(Query\AbstractQuery::LIMIT)
            ),
            Compiler::word(
                'OFFSET',
                $query->getChild(Query\AbstractQuery::OFFSET)
            ),
        ));
    }
}
