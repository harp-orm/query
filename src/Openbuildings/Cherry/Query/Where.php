<?php
namespace Openbuildings\Cherry;

/**
 * Abstract query to be extended by SELECT, UPDATE, DELETE
 * 
 * @package    Openbuildings\Cherry
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2013 OpenBuildings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
abstract class Query_Where extends Query {

	protected $current_where;

	public function limit($rows)
	{
		$this->children['LIMIT'] = new Statement_Number('LIMIT', $rows);

		return $this;
	}

	public function order_by($column, $direction = NULL)
	{
		$this->set_list('ORDER BY')->append(Query::new_direction($column, $direction));

		return $this;
	}

	/**
	 * @codeCoverageIgnore
	 */
	protected function current_where()
	{
		if ( ! $this->current_where)
		{
			$this->current_where =
			$this->children['WHERE'] = new Statement_Condition_Group('WHERE');
		}

		return $this->current_where;
	}

	public function and_where($column, $operator, $value)
	{
		$this->current_where()->append(Query::new_condition('AND', $column, $operator, $value));

		return $this;
	}

	public function where($column, $operator, $value)
	{
		return $this->and_where($column, $operator, $value);
	}

	public function or_where($column, $operator, $value)
	{
		$this->current_where()->append(Query::new_condition('OR', $column, $operator, $value));

		return $this;
	}

	public function where_open()
	{
		return $this->and_where_open();
	}

	public function where_close()
	{
		return $this->and_where_close();
	}

	public function and_where_open()
	{
		$child = new Statement_Condition_Group('AND', $this->current_where());
		$this->current_where()->append($child);
		$this->current_where = $child;

		return $this;
	}

	public function or_where_open()
	{
		$child = new Statement_Condition_Group('OR', $this->current_where());
		$this->current_where()->append($child);
		$this->current_where = $child;

		return $this;
	}

	public function and_where_close()
	{
		if (isset($this->current_where) AND $this->current_where->parent())
		{
			$this->current_where = $this->current_where->parent();
		}

		return $this;
	}

	public function or_where_close()
	{
		return $this->and_where_close();
	}
}