<?php namespace Openbuildings\Cherry;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Compiler_Values extends Compiler
{
	public function combine($items)
	{
		return Arr::join(', ', Arr::map(__NAMESPACE__."\Compiler_Values::render", $items));
	}

	public function render(SQL_Values $item)
	{
		$placeholders = array_fill(0, count($item->parameters()), '?');

		return '('.join(', ', $placeholders).')';
	}
}


