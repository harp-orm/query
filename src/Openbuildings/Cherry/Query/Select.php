<?php
namespace Openbuildings\Cherry;

class Query_Select extends Query_Where {

	protected static $children_names = array(
		'DISTINCT',
		'SELECT',
		'FROM',
		'JOIN',
		'WHERE',
		'GROUP BY',
		'HAVING',
		'ORDER BY',
		'LIMIT',
		'OFFSET',
	);

	protected $current_having;

	public function __construct(array $columns = array())
	{
		parent::__construct('SELECT');
		
		$this->select_array($columns);
	}

	public function distinct()
	{
		$this->children['DISTINCT'] = new Statement('DISTINCT');

		return $this;
	}

	public function from($tables)
	{
		$tables = func_get_args();

		$table_statements = array_map('Openbuildings\Cherry\Query::new_aliased_table', $tables);

		$this->set_list('FROM', $table_statements);

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
		$column_statements = array_map('Openbuildings\Cherry\Query::new_aliased_column', $columns);

		$this->set_list('SELECT', $column_statements, Query::new_column('*'), FALSE);

		return $this;
	}

	public function join($table, $type = NULL)
	{
		$this->last_join = Query::new_join($table, $type);

		if ( ! isset($this->children['JOIN'])) 
		{
			$this->children['JOIN'] = new Statement();
		}

		$this->children['JOIN']->append($this->last_join);

		return $this;
	}

	public function on($column, $operator, $foreign_column)
	{
		$this->last_join->set_on(Query::new_column($column), $operator, Query::new_column($foreign_column));

		return $this;
	}

	public function using($columns)
	{
		$columns = is_array($columns) ? $columns : array($columns);
		$column_statements = array_map('Openbuildings\Cherry\Query::new_column', $columns);

		$this->last_join->set_using($column_statements);

		return $this;
	}

	public function group_by($column, $direction = NULL)
	{
		$this->set_list('GROUP BY', Query::new_direction($column, $direction));

		return $this;
	}

	protected function current_having()
	{
		if ( ! $this->current_having)
		{
			$this->current_having =
			$this->children['HAVING'] = new Statement_Condition_Group('HAVING');
		}

		return $this->current_having;
	}

	public function and_having($column, $operator, $value)
	{
		$this
			->current_having()
				->append(Query::new_condition('AND', $column, $operator, $value));

		return $this;
	}

	public function having($column, $operator, $value)
	{
		return $this->and_having($column, $operator, $value);
	}

	public function or_having($column, $operator, $value)
	{
		$this
			->current_having()
				->append(Query::new_condition('OR', $column, $operator, $value));

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
		$child = new Statement_Condition_Group('AND', $this->current_having());
		$this->current_having()->append($child);
		$this->current_having = $child;

		return $this;
	}

	public function or_having_open()
	{
		$child = new Statement_Condition_Group('OR', $this->current_having());
		$this->current_having()->append($child);
		$this->current_having = $child;

		return $this;
	}

	public function and_having_close()
	{
		if (isset($this->current_having) AND $this->current_having->parent())
		{
			$this->current_having = $this->current_having->parent();
		}

		return $this;
	}

	public function or_having_close()
	{
		return $this->and_having_close();
	}
}