<?php namespace Openbuildings\Cherry;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Compiler_Insert extends Compiler
{
	public static function render(Query_Insert $query)
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
				Compiler_Values::combine($query->children(Query::VALUES))
			),
			Compiler::word('SET',
				Compiler_Set::combine(
					$query->children(Query::SET)
				)
			),
			Compiler::word('SELECT',
				Compiler_Condition::combine(
					$query->children(Query::WHERE)
				)
			),
			$query->children(Query::SELECT) ? Compiler_Select::render($query->children(Query::SELECT)) : NULL,
		));
	}
}
