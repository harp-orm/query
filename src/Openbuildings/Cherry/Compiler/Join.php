<?php namespace Openbuildings\Cherry;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Compiler_Join extends Compiler
{
	public static function combine($items)
	{
		return Arr::join(' ', Arr::map(__NAMESPACE__."\Compiler_Join::render", $items));
	}

	public static function render(SQL_Join $join)
	{
		return self::expression(array(
			$join->type(),
			'JOIN', 
			Compiler_Aliased::render($join->table()),
			$join->condition(),
		));
	}
}
