<?php

namespace CL\Atlas\Compiler;

use CL\Atlas\Query;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Insert
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
            $query->getType(),
            Compiler::word('INTO', $query->getTable()),
            Columns::render($query->getColumns()),
            Compiler::word(
                'VALUES',
                Values::combine($query->getValues())
            ),
            Compiler::word(
                'SET',
                Set::combine(
                    $query->getSet()
                )
            ),
            $query->getSelect()
                ? Select::render($query->getSelect())
                : null,
        ));
    }

    public static function parameters(Query\Insert $query)
    {
        return Compiler::parameters(array(
            $query->getTable(),
            $query->getSet(),
            $query->getValues(),
            $query->getSelect(),
        ));
    }
}
