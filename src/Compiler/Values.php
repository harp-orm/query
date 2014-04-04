<?php

namespace CL\Atlas\Compiler;

use CL\Atlas\Arr;
use CL\Atlas\SQL;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Values extends Compiler
{
    /**
     * Render multiple Values objects
     * @param  array|null $items
     * @return array|null
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
