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
class Aliased extends Compiler
{
    /**
     * Render Multiple Aliased objects
     *
     * @param  array|null $items
     * @return string|null
     */
    public static function combine($items)
    {
        return Arr::join(', ', Arr::map('CL\Atlas\Compiler\Aliased::render', $items));
    }

    /**
     * Render SQL for Aliased
     *
     * @param  SQL\Aliased $aliased
     * @return string
     */
    public static function render(SQL\Aliased $aliased)
    {
        $content = $aliased->getContent();

        if ($content instanceof Query\Select) {
            $content = "(".Select::render($content).")";
        }

        return Compiler::expression(array(
            $content,
            Compiler::word('AS', $aliased->getAlias())
        ));
    }
}
