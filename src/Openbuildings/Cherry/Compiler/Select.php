<?php namespace Openbuildings\Cherry;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Compiler_Select extends Compiler
{
	public function render(Query_Select $select)
	{
		return static::expression(array(
			'SELECT',
			$select->children(Query_Select::DISTINCT) ? 'DISTINCT' : NULL,
			$this->aliased_set(
				$select->children(Query_Select::COLUMNS),
				'*'
			),
			$this->word('FROM', 
				$this->aliased_set(
					$select->children(Query_Select::FROM)
				)
			),
			$this->joins(
				$select->children(Query_Select::JOIN)
			),
			$this->word('WHERE', 
				$this->conditions_set(
					$select->children(Query_Select::WHERE)
				)
			),
			$this->word('GROUP BY', 
				$this->set(
					$select->children(Query_Select::GROUP_BY)
				)
			),
			$this->word('HAVING', 
				$this->conditions_set(
					$select->children(Query_Select::HAVING)
				)
			),
			$this->word('ORDER BY', 
				$this->set(
					$select->children(Query_Select::ORDER_BY)
				)
			),
			$this->word('LIMIT', 
				$select->children(Query_Select::LIMIT)
			),
			$this->word('OFFSET', 
				$select->children(Query_Select::OFFSET)
			)
		));
	}
}
