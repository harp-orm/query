<?php namespace Openbuildings\Cherry;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Compiler_Direction extends Compiler
{
	public function combine($items)
	{
		return Arr::join(', ', Arr::map(__NAMESPACE__."\Compiler_Direction::render", $items));
	}

	public function render(SQL_Direction $item)
	{
		return Compiler::expression(array(
			$item->content(),
			$item->direction(),
		));
	}
}
