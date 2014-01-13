<?php namespace Openbuildings\Cherry;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Query_Select extends Query
{
	const DISTINCT = 1;
	const COLUMNS = 2;
	const FROM = 3;
	const JOIN = 4;
	const WHERE = 5;
	const GROUP_BY = 6;
	const HAVING = 7;
	const ORDER_BY = 8;
	const LIMIT = 10;
	const OFFSET = 11;

	public function where($where)
	{
		$this->children[self::WHERE] []= new SQL_Condition($where, array_slice(func_get_args(), 1));

		return $this;
	}

	public function join($table, $condition, $type = NULL)
	{
		$this->children[self::JOIN] []= new SQL_Join($table, $condition, $type);
		return $this;
	}

	protected function add($name, $children)
	{
		if ($children instanceof SQL)
		{
			$this->children[$name] []= $children;
		}
		else
		{
			$children = SQL_Aliased::from_array( (array) $children);
			
			foreach ($children as $child)
			{
				$this->children[$name] []= $child;
			}
		}
	}

	public function from($table)
	{
		$this->add(self::FROM, $table);

		return $this;
	}

	public function columns($column)
	{
		$this->add(self::COLUMNS, $column);

		return $this;
	}

	public function order($column, $direction = NULL)
	{
		$this->children[self::ORDER_BY] []= new SQL_Direction($column, $direction);
		return $this;
	}

	public function group($column, $direction = NULL)
	{
		$this->children[self::GROUP_BY] []= new SQL_Direction($column, $direction);
		return $this;
	}

	public function having($having)
	{
		$this->children[self::HAVING] []= new SQL_Condition($having, array_slice(func_get_args(), 1));

		return $this;
	}

	public function limit($limit)
	{
		$this->children[self::LIMIT] = (int) $limit;
		return $this;
	}

	public function offset($offset)
	{
		$this->children[self::OFFSET] = (int) $offset;
		return $this;
	}

	public function distinct($distinct = TRUE)
	{
		$this->children[self::DISTINCT] = (bool) $distinct;
		return $this;
	}
}
