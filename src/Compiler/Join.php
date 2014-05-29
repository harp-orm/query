<?php

namespace Harp\Query\Compiler;

use Harp\Query\Arr;
use Harp\Query\SQL;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Join
{
    /**
     * Render multiple Join objects
     * @param  SQL\Join[]|null $items
     * @return string|null
     */
    public static function combine($items)
    {
        return Arr::join(' ', Arr::map(__NAMESPACE__."\Join::render", $items));
    }

    /**
     * Render a Join object
     * @param  SQL\Join $join
     * @return string
     */
    public static function render(SQL\Join $join)
    {
        return Compiler::expression(array(
            $join->getType(),
            'JOIN',
            $join->getTable() instanceof SQL\Aliased
                ? Aliased::render($join->getTable())
                : $join->getTable(),
            $join->getCondition(),
        ));
    }
}
