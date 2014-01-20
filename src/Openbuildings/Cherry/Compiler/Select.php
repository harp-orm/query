<?php namespace Openbuildings\Cherry;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Compiler_Select extends Compiler
{
	public static function render(Query_Select $query)
	{
		return Compiler::expression(array(
			'SELECT',
			$query->children(Query::TYPE),
			Compiler_Aliased::combine($query->children(Query::COLUMNS)) ?: '*',
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
			Compiler::word('GROUP BY',
				Compiler_Direction::combine(
					$query->children(Query::GROUP_BY)
				)
			),
			Compiler::word('HAVING',
				Compiler_Condition::combine(
					$query->children(Query::HAVING)
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
			Compiler::word('OFFSET',
				$query->children(Query::OFFSET)
			),
		));
	}
}
