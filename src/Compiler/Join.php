<?php

namespace Harp\Query\Compiler;

use Harp\Query\Arr;
use Harp\Query\SQL;

/**
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class Join
{
    /**
     * Render multiple Join objects
     * @param  SQL\Join[]|null $items
     * @return string|null
     */
    public static function combine($items)
    {
        return Arr::join(' ', Arr::map(__CLASS__."::render", $items));
    }

    /**
     * @param  array  $condition
     * @return string
     */
    public static function renderArrayCondition(array $condition)
    {
        $statements = array();

        foreach ($condition as $column => $foreignColumn) {
            $statements [] = Compiler::expression(array(
                Compiler::name($column),
                '=',
                Compiler::name($foreignColumn)
            ));
        }

        return 'ON '.join(' AND ', $statements);
    }

    /**
     * Render a Join object
     *
     * @param  SQL\Join $join
     * @return string
     */
    public static function render(SQL\Join $join)
    {
        $condition = $join->getCondition();

        return Compiler::expression(array(
            $join->getType(),
            'JOIN',
            $join->getTable() instanceof SQL\Aliased
                ? Aliased::render($join->getTable())
                : $join->getTable(),
            is_array($condition)
                ? self::renderArrayCondition($condition)
                : $condition,
        ));
    }
}
