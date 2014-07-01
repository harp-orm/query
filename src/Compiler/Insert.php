<?php

namespace Harp\Query\Compiler;

use Harp\Query;

/**
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
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
        return Compiler::withDb($query->getDb(), function () use ($query) {

            $table = $query->getTable();
            $select = $query->getSelect();

            return Compiler::expression(array(
                'INSERT',
                $query->getType(),
                Compiler::word('INTO', $table !== null ? Aliased::render($table) : null),
                Columns::render($query->getColumns()),
                Compiler::word('VALUES', Values::combine($query->getValues())),
                Compiler::word('SET', Set::combine($query->getSet())),
                $select !== null ? Select::render($select) : null,
            ));
        });
    }

    /**
     * @param  QueryInsert $query
     * @return array
     */
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
