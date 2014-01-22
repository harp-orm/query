<?php namespace CL\Cherry\Compiler;

use CL\Cherry\Query\Query;
use CL\Cherry\Query\UpdateQuery;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class UpdateCompiler extends Compiler
{
	public static function render(UpdateQuery $query)
	{
		return Compiler::expression(array(
			'UPDATE',
			$query->children(Query::TYPE),
			AliasedCompiler::combine($query->children(Query::TABLE)),
			JoinCompiler::combine(
				$query->children(Query::JOIN)
			),
			Compiler::word('SET',
				SetCompiler::combine(
					$query->children(Query::SET)
				)
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
