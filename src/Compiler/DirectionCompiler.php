<?php namespace CL\Atlas\Compiler;

use CL\Atlas\Arr;
use CL\Atlas\SQL\DirectionSQL;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class DirectionCompiler extends Compiler
{
	public static function combine($items)
	{
		return Arr::join(', ', Arr::map(__NAMESPACE__."\DirectionCompiler::render", $items));
	}

	public static function render(DirectionSQL $item)
	{
		return Compiler::expression(array(
			$item->content(),
			$item->direction(),
		));
	}
}
