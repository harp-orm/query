<?php

namespace CL\Atlas\Compiler;

use CL\Atlas\Arr;
use CL\Atlas\SQL;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Columns
{
    /**
     * Render Columns
     * @param  SQL\Columns|null $items
     * @return string
     */
    public static function combine($items)
    {
        return $items ? Columns::render($items) : null;
    }

    /**
     * Render Columns object
     * @param  SQL\Columns $item
     * @return string
     */
    public static function render(SQL\Columns $item)
    {
        return Compiler::braced(
            Arr::join(', ', $item->getColumns())
        );
    }
}
