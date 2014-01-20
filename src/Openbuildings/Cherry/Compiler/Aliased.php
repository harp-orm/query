<?php namespace Openbuildings\Cherry;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Compiler_Aliased extends Compiler
{
	public static function combine($items)
	{
		return Arr::join(', ', Arr::map(__NAMESPACE__."\Compiler_Aliased::render", $items));
	}

	public static function render(SQL_Aliased $aliased)
	{
		$content = $aliased->content();

		if ($content instanceof Query_Select) 
		{
			$content = "(".Compiler_Select::render($content).")";
		}

		return Compiler::expression(array(
			$content,
			Compiler::word('AS', $aliased->alias())
		));
	}
}
