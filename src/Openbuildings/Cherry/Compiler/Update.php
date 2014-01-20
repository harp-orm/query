<?php namespace Openbuildings\Cherry;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Compiler_Update extends Compiler
{
	public static function render(Query_Update $query)
	{
		return Compiler::expression(array(
			'UPDATE',
			$query->children(Query::TYPE),
			Compiler_Aliased::combine($query->children(Query::TABLE)),
			Compiler_Join::combine(
				$query->children(Query::JOIN)
			),
			Compiler::word('SET',
				Compiler_Set::combine(
					$query->children(Query::SET)
				)
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
