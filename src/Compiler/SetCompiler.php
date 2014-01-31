<?php namespace CL\Atlas\Compiler;

use CL\Atlas\Arr;
use CL\Atlas\SQL\SQL;
use CL\Atlas\SQL\SetSQL;
use CL\Atlas\Query\SelectQuery;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class SetCompiler extends Compiler
{
    public static function combine($items)
    {
        return Arr::join(', ', Arr::map(__NAMESPACE__."\SetCompiler::render", $items));
    }

    public static function render(SetSQL $item)
    {
        if ($item->value() instanceof SQL)
        {
            $value = $item->value()->content();
        }
        elseif ($item->value() instanceof SelectQuery)
        {
            $value = Compiler::braced(SelectCompiler::render($item->value()));
        }
        else
        {
            $value = '?';
        }

        return $item->content().' = '.$value;
    }
}
