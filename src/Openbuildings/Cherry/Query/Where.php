<?php
namespace Openbuildings\Cherry;

class Query_Where extends Statement {

	public $children = array();

	protected $where;

	protected function add_where_child($condition, Statement $child)
	{
		if ( ! $this->where)
		{
			$this->where = new Statement_Condition_Group('WHERE');
			$this->children []= $this->where;
		}

		if (count($this->where->children)) 
		{
			$this->where->children []= $condition;
		}

		$this->where->children []= $child;

		return $child;
	}

	public function and_where($column, $operator, $value)
	{
		$this->add_where_child('AND', new Statement_Condition($column, $operator, $value));

		return $this;
	}

	public function where($column, $operator, $value)
	{
		return $this->and_where($column, $operator, $value);
	}

	public function or_where($column, $operator, $value)
	{
		$this->add_where_child('OR', new Statement_Condition($column, $operator, $value));

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
		$child = $this->add_where_child('AND', new Statement_Condition_Group('WHERE', $this->where));
		$this->where = $child;

		return $this;
	}

	public function or_where_open()
	{
		$child = $this->add_where_child('OR', new Statement_Condition_Group('WHERE', $this->where));
		$this->where = $child;

		return $this;
	}

	public function and_where_close()
	{
		if (isset($this->where) AND $this->where->parent)
		{
			$this->where = $this->where->parent;
		}

		return $this;
	}

	public function or_where_close()
	{
		return $this->and_where_close();
	}
}