<?php

namespace Harp\Query\Compiler;

use Harp\Query\Arr;
use Harp\Query\SQL;
use Harp\Query;

/**
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class Aliased
{
    /**
     * Render Multiple Aliased objects
     *
     * @param  SQL\Aliased[]|null $items
     * @return string|null
     */
    public static function combine($items)
    {
        return Arr::join(', ', Arr::map(__CLASS__.'::render', $items));
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
        } else {
            $content = Compiler::name($content);
        }

        return Compiler::expression(array(
            $content,
            Compiler::word('AS', Compiler::name($aliased->getAlias()))
        ));
    }
}
