<?php namespace Openbuildings\Cherry;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Query_Select extends Query
{
	public function where($where)
	{
		$this->children['WHERE'] []= ($where instanceof SQL) ? $where : new SQL_Condition($where);
	}

	public function join($table, $condition, $type = NULL)
	{
		$this->children['JOIN'] []= new SQL_Join($type, $table, $condition);
	}

	protected function add($name, array $children)
	{
		foreach ($children as $child) 
		{
			$this->children[$name] []= $child;
		}
	}

	public function from($table)
	{
		$tables = SQL_Aliased::from_array( (array) $table);
		foreach ($tables as $table) 
		{
			$this->children['FROM'] []= $table;
		}
	}

	public function columns($column)
	{
		$columns = SQL_Aliased::from_array( (array) $column);
		foreach ($columns as $column) 
		{
			$this->children['COLUMNS'] []= $column;
		}
	}

	public function order($column, $direction = NULL)
	{
		$this->children['ORDER'] []= new SQL_Direction($column, $direction);
	}

	public function group($group)
	{
		$this->children['GROUP'] []= new SQL_Direction($column, $direction);
	}

	public function having($having)
	{
		$this->children['HAVING'] []= ($having instanceof SQL) ? $having : new SQL_Condition($having);
	}

	public function limit($limit)
	{
		$this->children['LIMIT'] = (int) $limit;
	}

	public function offset($offset)
	{
		$this->children['offset'] = (int) $limit;
	}

	public function distinct($distinct = TRUE)
	{
		$this->children['distinct'] = (bool) $distinct;
	}
}
