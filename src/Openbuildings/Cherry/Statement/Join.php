<?php
namespace Openbuildings\Cherry;

class Statement_Join extends Statement {

	protected $table;
	protected $column;
	protected $operator;
	protected $foreign_column;
	protected $using;
	protected $type;

	public function __construct(Statement $table, $type = NULL)
	{
		parent::__construct('JOIN');

		$this->type = $type;
		$this->table = $table;
		$this->children []= $table;
	}

	public function set_on(Statement $column, $operator, Statement $foreign_column)
	{
		$this->column = $column;
		$this->operator = $operator;
		$this->foreign_column = $foreign_column;
		$this->using = NULL;

		$this->children []= $column;
		$this->children []= $foreign_column;
	}

	public function set_using(array $using)
	{
		$this->using = $using;
		$this->children = $using;
		$this->column = $this->operator = $this->foreign_column = NULL;
	}

	public function table()
	{
		return $this->table;
	}

	public function column()
	{
		return $this->column;
	}

	public function type()
	{
		return $this->type;
	}

	public function foreign_column()
	{
		return $this->foreign_column;
	}

	public function operator()
	{
		return $this->operator;
	}

	public function using()
	{
		return $this->using;
	}

}