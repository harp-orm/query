<?php namespace CL\Cherry\Compiler;

use CL\Cherry\Arr;
use CL\Cherry\SQL\ValuesSQL;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class ValuesCompiler extends Compiler
{
	public static function combine($items)
	{
		return Arr::join(', ', Arr::map(__NAMESPACE__."\ValuesCompiler::render", $items));
	}

	public static function render(ValuesSQL $item)
	{
		$placeholders = array_fill(0, count($item->parameters()), '?');

		return '('.join(', ', $placeholders).')';
	}
}
