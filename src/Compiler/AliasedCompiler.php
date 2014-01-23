<?php namespace CL\Cherry\Compiler;

use CL\Cherry\Arr;
use CL\Cherry\SQL\AliasedSQL;
use CL\Cherry\Query\SelectQuery;
use CL\Cherry\Compiler\Compiler;
use CL\Cherry\Compiler\SelectCompiler;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class AliasedCompiler extends Compiler
{
	public static function combine($items)
	{
		return Arr::join(', ', Arr::map('CL\Cherry\Compiler\AliasedCompiler::render', $items));
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
