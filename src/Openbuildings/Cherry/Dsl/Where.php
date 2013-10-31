<?php
namespace Openbuildings\Cherry;

trait Dsl_Where {

	protected function add_where_child($condition, Statement $child)
	{
		if ( ! isset($this->children['where']))
		{
			$this->children['where'] = new Statement_Condition_Group('WHERE');
		}

		if (count($this->children['where']->children)) 
		{
			$this->children['where']->children []= $condition;
		}

		$this->children['where']->children []= $child;

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
		$child = $this->add_where_child('AND', new Statement_Condition_Group('WHERE', $this->children['where']));
		$this->children['where'] = $child;

		return $this;
	}

	public function or_where_open()
	{
		$child = $this->add_where_child('OR', new Statement_Condition_Group('WHERE', $this->children['where']));
		$this->children['where'] = $child;

		return $this;
	}

	public function and_where_close()
	{
		if (isset($this->children['where']) AND $this->children['where']->parent)
		{
			$this->children['where'] = $this->children['where']->parent;
		}

		return $this;
	}

	public function or_where_close()
	{
		return $this->and_where_close();
	}
}