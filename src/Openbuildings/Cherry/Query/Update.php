<?php namespace Openbuildings\Cherry;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Query_Update extends Query
{
	public function type($type)
	{
		$this->children[Query::TYPE] = $type;
		return $this;
	}

	public function table($table, $alias = NULL)
	{
		$this->addChildrenObjects(Query::TABLE, $table, $alias, __NAMESPACE__.'\SQL_Aliased::factory');

		return $this;
	}

	public function join($table, $condition, $type = NULL)
	{
		$this->children[Query::JOIN] []= new SQL_Join($table, $condition, $type);
		return $this;
	}

	public function set(array $values)
	{
		foreach ($values as $column => $value)
		{
			$this->children[Query::SET] []= new SQL_Set($column, $value);
		}

		return $this;
	}

	public function where($where)
	{
		$this->children[Query::WHERE] []= new SQL_Condition($where, array_slice(func_get_args(), 1));

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

	public function sql()
	{
		return Compiler_Update::render($this);
	}
}
