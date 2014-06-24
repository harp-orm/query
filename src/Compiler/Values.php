<?php

namespace Harp\Query\Compiler;

use Harp\Query\Arr;
use Harp\Query\SQL;

/**
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class Values
{
    /**
     * Render multiple Values objects
     * @param  SQL\Values[]|null $items
     * @return string|null
     */
    public static function combine($items)
    {
        return Arr::join(', ', Arr::map(__NAMESPACE__."\Values::render", $items));
    }

    /**
     * Render Values object
     * @param  SQL\Values $item
     * @return string
     */
    public static function render(SQL\Values $item)
    {
        $placeholders = array_fill(0, count($item->getParameters()), '?');

        return '('.join(', ', $placeholders).')';
    }
}
