<?php namespace Openbuildings\Cherry\Compiler;

use Openbuildings\Cherry\Arr;
use Openbuildings\Cherry\SQL\AliasedSQL;
use Openbuildings\Cherry\Query\SelectQuery;
use Openbuildings\Cherry\Compiler\Compiler;
use Openbuildings\Cherry\Compiler\SelectCompiler;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class AliasedCompiler extends Compiler
{
	public static function combine($items)
	{
		return Arr::join(', ', Arr::map('Openbuildings\Cherry\Compiler\AliasedCompiler::render', $items));
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
