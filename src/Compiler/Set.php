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
     * @param  SQL\Set $item
     * @return string
     */
    public static function renderValue(SQL\Set $item)
    {
        $value = $item->getValue();
        $content = $item->getContent();

        if ($value instanceof SQL\SQL) {
            return $value->getContent();
        } elseif ($value instanceof Query\Select) {
            return Compiler::braced(Select::render($value));
        } elseif ($item instanceof SQL\SetMultiple AND is_string($content)) {
            return self::renderMultiple($value, $content, $item->getKey());
        } else {
            return '?';
        }
    }

    /**
     * @param  array  $values
     * @param  string $column
     * @param  string $key
     * @return string
     */
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
