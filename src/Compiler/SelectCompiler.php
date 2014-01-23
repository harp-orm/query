<?php namespace CL\Cherry\Compiler;

use CL\Cherry\Query\Query;
use CL\Cherry\Query\SelectQuery;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class SelectCompiler extends Compiler
{
	public static function render(SelectQuery $query)
	{
		return Compiler::expression(array(
			'SELECT',
			$query->children(Query::TYPE),
			AliasedCompiler::combine($query->children(Query::COLUMNS)) ?: '*',
			Compiler::word('FROM',
				AliasedCompiler::combine($query->children(Query::FROM))
			),
			JoinCompiler::combine(
				$query->children(Query::JOIN)
			),
			Compiler::word('WHERE',
				ConditionCompiler::combine(
					$query->children(Query::WHERE)
				)
			),
			Compiler::word('GROUP BY',
				DirectionCompiler::combine(
					$query->children(Query::GROUP_BY)
				)
			),
			Compiler::word('HAVING',
				ConditionCompiler::combine(
					$query->children(Query::HAVING)
				)
			),
			Compiler::word('ORDER BY',
				DirectionCompiler::combine(
					$query->children(Query::ORDER_BY)
				)
			),
			Compiler::word('LIMIT',
				$query->children(Query::LIMIT)
			),
			Compiler::word('OFFSET',
				$query->children(Query::OFFSET)
			),
		));
	}
}
