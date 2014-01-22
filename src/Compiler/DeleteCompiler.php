<?php namespace CL\Cherry\Compiler;

use CL\Cherry\Arr;
use CL\Cherry\Query\Query;
use CL\Cherry\Query\DeleteQuery;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class DeleteCompiler extends Compiler
{
	public static function render(DeleteQuery $query)
	{
		return Compiler::expression(array(
			'DELETE',
			$query->children(Query::TYPE),
			Arr::join(', ', $query->children(Query::TABLE)),
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
			Compiler::word('ORDER BY',
				DirectionCompiler::combine(
					$query->children(Query::ORDER_BY)
				)
			),
			Compiler::word('LIMIT',
				$query->children(Query::LIMIT)
			),
		));
	}
}
