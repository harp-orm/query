<?php namespace CL\Atlas\Compiler;

use CL\Atlas\Arr;
use CL\Atlas\SQL\AliasedSQL;
use CL\Atlas\SQL\JoinSQL;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class JoinCompiler extends Compiler
{
    public static function combine($items)
    {
        return Arr::join(' ', Arr::map(__NAMESPACE__."\JoinCompiler::render", $items));
    }

    public static function render(JoinSQL $join)
    {
        return self::expression(array(
            $join->type(),
            'JOIN',
            $join->table() instanceof AliasedSQL ? AliasedCompiler::render($join->table()) : $join->table(),
            $join->condition(),
        ));
    }
}
