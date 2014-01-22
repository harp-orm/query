<?php namespace Openbuildings\Cherry\Compiler;

use Openbuildings\Cherry\Arr;
use Openbuildings\Cherry\SQL\DirectionSQL;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
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
