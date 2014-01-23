<?php namespace CL\Atlas\Compiler;

use CL\Atlas\Arr;
use CL\Atlas\SQL\AliasedSQL;
use CL\Atlas\Query\SelectQuery;
use CL\Atlas\Compiler\Compiler;
use CL\Atlas\Compiler\SelectCompiler;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class AliasedCompiler extends Compiler
{
	public static function combine($items)
	{
		return Arr::join(', ', Arr::map('CL\Atlas\Compiler\AliasedCompiler::render', $items));
	}

	public static function render(AliasedSQL $aliased)
	{
		$content = $aliased->content();

		if ($content instanceof SelectQuery)
		{
			$content = "(".SelectCompiler::render($content).")";
		}

		return Compiler::expression(array(
			$content,
			Compiler::word('AS', $aliased->alias())
		));
	}
}
