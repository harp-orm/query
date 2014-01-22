<?php namespace Openbuildings\Cherry\Compiler;

use Openbuildings\Cherry\Arr;
use Openbuildings\Cherry\Query\Query;
use Openbuildings\Cherry\Query\InsertQuery;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class InsertCompiler extends Compiler
{
	public static function render(InsertQuery $query)
	{
		return Compiler::expression(array(
			'INSERT',
			$query->children(Query::TYPE),
			Compiler::word('INTO', $query->children(Query::TABLE)),
			Compiler::braced(
				Arr::join(', ',
					$query->children(Query::COLUMNS)
				)
			),
			Compiler::word('VALUES',
				ValuesCompiler::combine($query->children(Query::VALUES))
			),
			Compiler::word('SET',
				SetCompiler::combine(
					$query->children(Query::SET)
				)
			),
			Compiler::word('SELECT',
				ConditionCompiler::combine(
					$query->children(Query::WHERE)
				)
			),
			$query->children(Query::SELECT) ? SelectCompiler::render($query->children(Query::SELECT)) : NULL,
		));
	}
}
