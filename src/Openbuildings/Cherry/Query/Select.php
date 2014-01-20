<?php namespace Openbuildings\Cherry;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Query_Select extends Query
{
	public function type($type)
	{
		$this->children[Query::TYPE] = $type;
		return $this;
	}

	public function columns($column, $alias = NULL)
	{
		$this->addChildrenObjects(Query::COLUMNS, $column, $alias, __NAMESPACE__.'\SQL_Aliased::factory');

		return $this;
	}

	public function from($table, $alias = NULL)
	{
		$this->addChildrenObjects(Query::FROM, $table, $alias, __NAMESPACE__.'\SQL_Aliased::factory');

		return $this;
	}

	public function join($table, $condition, $type = NULL)
	{
		$this->children[Query::JOIN] []= new SQL_Join($table, $condition, $type);
		return $this;
	}

	public function where($where)
	{
		$this->children[Query::WHERE] []= new SQL_Condition($where, array_slice(func_get_args(), 1));

		return $this;
	}

	public function group($column, $direction = NULL)
	{
		$this->addChildrenObjects(Query::GROUP_BY, $column, $direction, __NAMESPACE__.'\SQL_Direction::factory');

		return $this;
	}

	public function having($having)
	{
		$this->children[Query::HAVING] []= new SQL_Condition($having, array_slice(func_get_args(), 1));

		return $this;
	}

	public function order($column, $direction = NULL)
	{
		$this->addChildrenObjects(Query::ORDER_BY, $column, $direction, __NAMESPACE__.'\SQL_Direction::factory');

		return $this;
	}

	public function limit($limit)
	{
		$this->children[Query::LIMIT] = (int) $limit;
		return $this;
	}

	public function offset($offset)
	{
		$this->children[Query::OFFSET] = (int) $offset;
		return $this;
	}

	public function sql()
	{
		return Compiler_Select::render($this);
	}
}
