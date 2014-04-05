<?php

namespace CL\Atlas\Compiler;

use CL\Atlas\Arr;
use CL\Atlas\SQL;
use CL\Atlas\Query;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Set
{
    /**
     * Render multiple Set objects
     * @param  array|null $items
     * @return array|null
     */
    public static function combine($items)
    {
        return Arr::join(', ', Arr::map(__NAMESPACE__."\Set::render", $items));
    }

    /**
     * Render the value of Set object
     * @param  mixed $value
     * @return string
     */
    public static function renderValue($value)
    {
        if ($value instanceof SQL\SQL) {
            return $value->getContent();
        } elseif ($value instanceof Query\Select) {
            return Compiler::braced(Select::render($value));
        } else {
            return '?';
        }
    }

    /**
     * Render a Set object
     * @param  SQL\Set $item
     * @return string
     */
    public static function render(SQL\Set $item)
    {
        return $item->getContent().' = '.self::renderValue($item->getValue());
    }
}
