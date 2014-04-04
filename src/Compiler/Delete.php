<?php

namespace CL\Atlas\Compiler;

use CL\Atlas\Arr;
use CL\Atlas\Query;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Delete extends Compiler
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
            $query->getChild(Query\AbstractQuery::TYPE),
            Arr::join(', ', $query->getChild(Query\AbstractQuery::TABLE)),
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
                'ORDER BY',
                Direction::combine(
                    $query->getChild(Query\AbstractQuery::ORDER_BY)
                )
            ),
            Compiler::word(
                'LIMIT',
                $query->getChild(Query\AbstractQuery::LIMIT)
            ),
        ));
    }
}
