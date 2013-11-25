<?php
namespace Openbuildings\Cherry;

/**
 * Basic query class, extended by Select, Update, Delete.
 * 
 * @package    Openbuildings\Cherry
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2013 OpenBuildings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
abstract class Query extends Statement {

	protected static $children_names;

	public function children()
	{
		if (static::$children_names AND $this->children)
		{
			return Arr::extract(static::$children_names, $this->children);
		}

		return $this->children;
	}

	public function set_list($name, $children = NULL, $empty_value = NULL, $keyword = TRUE)
	{
		if ( ! isset($this->children[$name])) 
		{
			$this->children[$name] = new Statement_List($keyword ? $name : NULL, $children, $empty_value);
		}
		elseif ($children)
		{
			$this->children[$name]->append($children);
		}

		return $this->children[$name];
	}

	protected static function new_expression($content, $parameters)
	{
		return new Statement_Expression($content, $parameters);
	}

	protected static function new_column($column)
	{
		return new Statement_Column($column);
	}

	protected static function new_join($table, $type = NULL)
	{
		return new Statement_Join(Query::new_aliased_table($table), $type);
	}

	protected static function new_set($column, $value)
	{
		return new Statement_Set(Query::new_column($column), $value);
	}

	protected static function new_table($column)
	{
		return new Statement_Table($column);
	}

	protected static function new_condition($keyword, $column, $operator, $value)
	{
		return new Statement_Condition($keyword, new Statement_Column($column), $operator, $value);
	}

	protected static function new_direction($column, $direction)
	{
		return new Statement_Direction(new Statement_Column($column), $direction);
	}

	protected static function new_aliased_table($table)
	{
		if (is_array($table))
		{
			$alias = $table[1];
			$table = $table[0];
		}
		else
		{
			$alias = NULL;
		}

		if ( ! ($table instanceof Statement))
		{
			$table = new Statement_Table($table);
		}

		return $alias ? new Statement_Aliased($table, $alias) : $table;
	}

	protected static function new_aliased_column($column)
	{
		if (is_array($column))
		{
			$alias = $column[1];
			$column = $column[0];
		}
		else
		{
			$alias = NULL;
		}

		if ( ! ($column instanceof Statement))
		{
			$column = new Statement_Column($column);
		}

		return $alias ? new Statement_Aliased($column, $alias) : $column;

	}
}