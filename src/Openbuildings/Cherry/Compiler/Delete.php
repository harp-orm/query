<?php namespace Openbuildings\Cherry;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Compiler_Delete extends Compiler
{
	public static function render(Query_Delete $query)
	{
		return Compiler::expression(array(
			'DELETE',
			$query->children(Query::TYPE),
			Arr::join(', ', $query->children(Query::TABLE)),
			Compiler::word('FROM',
				Compiler_Aliased::combine($query->children(Query::FROM))
			),
			Compiler_Join::combine(
				$query->children(Query::JOIN)
			),
			Compiler::word('WHERE',
				Compiler_Condition::combine(
					$query->children(Query::WHERE)
				)
			),
			Compiler::word('ORDER BY',
				Compiler_Direction::combine(
					$query->children(Query::ORDER_BY)
				)
			),
			Compiler::word('LIMIT',
				$query->children(Query::LIMIT)
			),
		));
	}
}
