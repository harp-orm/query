<?php

namespace Harp\Query\Compiler;

use Harp\Query\Arr;
use Harp\Query\SQL;

/**
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class Direction
{
    /**
     * Render multiple Direction objects
     *
     * @param  SQL\Direction[]|null $items
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
