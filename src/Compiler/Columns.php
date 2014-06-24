<?php

namespace Harp\Query\Compiler;

use Harp\Query\Arr;
use Harp\Query\SQL;

/**
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
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
