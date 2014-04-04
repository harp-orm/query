<?php

namespace CL\Atlas\Compiler;

use CL\Atlas\Query;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Update extends Compiler
{
    /**
     * Render Update object
     * @param  Query\Update $query
     * @return string
     */
    public static function render(Query\Update $query)
    {
        return Compiler::expression(array(
            'UPDATE',
            $query->getChild(Query\AbstractQuery::TYPE),
            Aliased::combine($query->getChild(Query\AbstractQuery::TABLE)),
            Join::combine(
                $query->getChild(Query\AbstractQuery::JOIN)
            ),
            Compiler::word(
                'SET',
                Set::combine(
                    $query->getChild(Query\AbstractQuery::SET)
                )
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
