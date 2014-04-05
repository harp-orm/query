<?php

namespace CL\Atlas\Compiler;

use CL\Atlas\Arr;
use CL\Atlas\SQL;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Direction
{
    /**
     * Render multiple Direction objects
     *
     * @param  SQL\Direction[] $items
     * @return string|null
     */
    public static function combine($items)
    {
        return Arr::join(', ', Arr::map(__NAMESPACE__."\Direction::render", $items));
    }

    /**
     * Render a Direction object
     *
     * @param  SQL\Direction $item
     * @return string
     */
    public static function render(SQL\Direction $item)
    {
        return Compiler::expression(array(
            $item->getContent(),
            $item->getDirection(),
        ));
    }
}
