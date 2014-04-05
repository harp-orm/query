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
     * @param  SQL\Columns|null $columns
     * @return string|null
     */
    public static function render($columns)
    {
        return $columns ? Columns::renderItem($columns) : null;
    }

    /**
     * Render Columns object
     * @param  SQL\Columns $item
     * @return string
     */
    public static function renderItem(SQL\Columns $item)
    {
        return Compiler::braced(
            Arr::join(', ', $item->all())
        );
    }
}
