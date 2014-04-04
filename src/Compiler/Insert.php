<?php

namespace CL\Atlas\Compiler;

use CL\Atlas\Arr;
use CL\Atlas\Query;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Insert extends Compiler
{
    /**
     * Render a Insert object
     * @param  Query\Insert $query
     * @return string
     */
    public static function render(Query\Insert $query)
    {
        return Compiler::expression(array(
            'INSERT',
            $query->getChild(Query\AbstractQuery::TYPE),
            Compiler::word('INTO', $query->getChild(Query\AbstractQuery::TABLE)),
            Compiler::braced(
                Arr::join(', ', $query->getChild(Query\AbstractQuery::COLUMNS))
            ),
            Compiler::word(
                'VALUES',
                Values::combine($query->getChild(Query\AbstractQuery::VALUES))
            ),
            Compiler::word(
                'SET',
                Set::combine(
                    $query->getChild(Query\AbstractQuery::SET)
                )
            ),
            Compiler::word(
                'SELECT',
                Condition::combine(
                    $query->getChild(Query\AbstractQuery::WHERE)
                )
            ),
            $query->getChild(Query\AbstractQuery::SELECT)
                ? Select::render($query->getChild(Query\AbstractQuery::SELECT))
                : null,
        ));
    }
}
