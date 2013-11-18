<?php
namespace Openbuildings\Cherry;

class Query_Select extends Query_Where {

	public static $children_types = array(
		'Distinct',
		'Columns',
		'From',
		'Joins',
		'Where',
		'Groupby',
		'Having',
		'Orderby',
		'Limit',
		'Offset',
	);

	protected $current_having;

	public function __construct(array $columns = array())
	{
		$this->select_array($columns);
	}

	public function from($tables)
	{
		$from = $this->child('From');

		$tables = func_get_args();

		foreach ($tables AS $table) 
		{
			$from->add(new Statement_Part_Table($table));
		}

		return $this;
	}

	/**
	 * Choose the columns to select from.
	 *
	 * @param   mixed  $columns  column name or array($column, $alias) or object
	 * @return  $this
	 */
	public function select($columns = NULL)
	{
		$columns = func_get_args();

		$this->select_array($columns);

		return $this;
	}

	/**
	 * Choose the columns to select from, using an array.
	 *
	 * @param   array  $columns  list of column names or aliases
	 * @return  $this
	 */
	public function select_array(array $columns)
	{
		$select = $this->child('Columns');

		foreach ($columns AS $column) 
		{
			$select->add(new Statement_Part_Column($column));
		}

		return $this;
	}

	public function join($table, $type = NULL)
	{
		$this->last_join = new Statement_Part_Join(new Statement_Part_Table($table), $type);

		$this->child('Joins')
			->add($this->last_join);

		return $this;
	}

	public function on($column, $operator, $foreign_column)
	{
		$this->last_join->on($column, $operator, $foreign_column);

		return $this;
	}

	public function using($columns)
	{
		$this->last_join->using($columns);

		return $this;
	}

	public function group_by($column, $direction = NULL)
	{
		$this
			->child('Groupby')
			->add(new Statement_Part_Group($column, $direction));

		return $this;
	}

	protected function current_having()
	{
		if ( ! $this->current_having)
		{
			$this->current_having = 
			$this->children['Having'] = new Statement_Having();
		}

		return $this->current_having;
	}

	public function and_having($column, $operator, $value)
	{
		$this->current_having()->add('AND', new Statement_Part_Condition($column, $operator, $value));

		return $this;
	}

	public function having($column, $operator, $value)
	{
		return $this->and_having($column, $operator, $value);
	}

	public function or_having($column, $operator, $value)
	{
		$this->current_having()->add('OR', new Statement_Part_Condition($column, $operator, $value));

		return $this;
	}

	public function having_open()
	{
		return $this->and_having_open();
	}

	public function having_close()
	{
		return $this->and_having_close();
	}

	public function and_having_open()
	{
		$child = new Statement_Having($this->current_having());
		$this->current_having()->add('AND', $child);
		$this->current_having = $child;

		return $this;
	}

	public function or_having_open()
	{
		$child = new Statement_Having($this->current_having());
		$this->current_having()->add('OR', $child);
		$this->current_having = $child;

		return $this;
	}

	public function and_having_close()
	{
		if (isset($this->current_having) AND $this->current_having->parent)
		{
			$this->current_having = $this->current_having->parent;
		}

		return $this;
	}

	public function or_having_close()
	{
		return $this->and_having_close();
	}

	public function compile()
	{
		return 'SELECT '.$this->compose_children(static::$children_types);
	}

	public function humanize()
	{
		return 'SELECT '.$this->humanize_children(static::$children_types);
	}
}