<?php

namespace Harp\Query\Compiler;

use Harp\Query\Arr;
use Harp\Query\SQL;
use Harp\Query;

/**
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class Set
{
    /**
     * Render multiple Set objects
     * @param  SQL\Set[]|null $items
     * @return string|null
     */
    public static function combine($items)
    {
        return Arr::join(', ', Arr::map(__CLASS__."::render", $items));
    }

    /**
     * Render the value of Set object
     * @param  mixed $item
     * @return string
     */
    public static function renderValue(SQL\Set $item)
    {
        if ($item->getValue() instanceof SQL\SQL) {
            return $item->getValue()->getContent();
        } elseif ($item->getValue() instanceof Query\Select) {
            return Compiler::braced(Select::render($item->getValue()));
        } elseif ($item instanceof SQL\SetMultiple) {
            return self::renderMultiple($item->getValue(), $item->getContent(), $item->getKey());
        } else {
            return '?';
        }
    }

    public static function renderMultiple(array $values, $column, $key)
    {
        $cases = trim(str_repeat('WHEN ? THEN ? ', count($values)));

        return Compiler::expression(array(
            'CASE',
            $key,
            $cases,
            'ELSE',
            Compiler::name($column),
            'END'
        ));
    }

    /**
     * Render a Set object
     * @param  SQL\Set $item
     * @return string
     */
    public static function render(SQL\Set $item)
    {
        return Compiler::expression(array(
            Compiler::name($item->getContent()),
            '=',
            self::renderValue($item)
        ));
    }
}
