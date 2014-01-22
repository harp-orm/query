<?php namespace Openbuildings\Cherry\Compiler;

use Openbuildings\Cherry\Arr;
use Openbuildings\Cherry\SQL\AliasedSQL;
use Openbuildings\Cherry\SQL\JoinSQL;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class JoinCompiler extends Compiler
{
	public static function combine($items)
	{
		return Arr::join(' ', Arr::map(__NAMESPACE__."\JoinCompiler::render", $items));
	}

	public static function render(JoinSQL $join)
	{
		return self::expression(array(
			$join->type(),
			'JOIN',
			$join->table() instanceof AliasedSQL ? AliasedCompiler::render($join->table()) : $join->table(),
			$join->condition(),
		));
	}
}
