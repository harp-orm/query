<?php namespace Openbuildings\Cherry;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Compiler_Set extends Compiler
{
	public static function combine($items)
	{
		return Arr::join(', ', Arr::map(__NAMESPACE__."\Compiler_Set::render", $items));
	}

	public static function render(SQL_Set $item)
	{
		if ($item->value() instanceof SQL)
		{
			$value = $item->value()->content();
		}
		elseif ($item->value() instanceof Query_Select)
		{
			$value = Compiler::braced(Compiler_Select::render($item->value()));
		}
		else
		{
			$value = '?';
		}

		return $item->content().' = '.$value;
	}
}
