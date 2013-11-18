<?php
namespace Openbuildings\Cherry;

abstract class Query_Where extends Statement {

	protected $current_where;

	public function distinct()
	{
		$this
			->child('Distinct');

		return $this;
	}


	public function limit($rows)
	{
		$this
			->child('Limit')
			->value($rows);

		return $this;
	}

	public function offset($rows)
	{
		$this
			->child('Offset')
			->value($rows);

		return $this;
	}

	public function order_by($column, $direction = NULL)
	{
		$this
			->child('Orderby')
			->add(new Statement_Part_Order($column, $direction));

		return $this;
	}

	protected function current_where()
	{
		if ( ! $this->current_where)
		{
			$this->current_where = 
			$this->children['Where'] = new Statement_Where();
		}

		return $this->current_where;
	}

	public function and_where($column, $operator, $value)
	{
		$this->current_where()->add('AND', new Statement_Part_Condition($column, $operator, $value));

		return $this;
	}

	public function where($column, $operator, $value)
	{
		return $this->and_where($column, $operator, $value);
	}

	public function or_where($column, $operator, $value)
	{
		$this->current_where()->add('OR', new Statement_Part_Condition($column, $operator, $value));

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
		$child = new Statement_Where($this->current_where());
		$this->current_where()->add('AND', $child);
		$this->current_where = $child;

		return $this;
	}

	public function or_where_open()
	{
		$child = new Statement_Where($this->current_where());
		$this->current_where()->add('OR', $child);
		$this->current_where = $child;

		return $this;
	}

	public function and_where_close()
	{
		if (isset($this->current_where) AND $this->current_where->parent)
		{
			$this->current_where = $this->current_where->parent;
		}

		return $this;
	}

	public function or_where_close()
	{
		return $this->and_where_close();
	}
}