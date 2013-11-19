<?php
namespace Openbuildings\Cherry;

class Statement_Part_Join extends Statement {

	protected $table;
	protected $type;
	protected $column;
	protected $operator;
	protected $foreign_column;
	protected $using;

	public function __construct(Statement_Part_Table $table, $type = NULL)
	{
		$this->table = $table;
		$this->type = $type;
	}

	public function on($column, $operator, $foreign_column)
	{
		$this->column = $column;
		$this->operator = $operator;
		$this->foreign_column = $foreign_column;

		$this->usign = NULL;

		$this->children []= $column;
		$this->children []= $foreign_column;
	}

	public function identifier()
	{
		return $this->table->identifier();
	}

	public function using($using)
	{
		$this->using = (array) $using;
	}

	public function compile_condition()
	{
		if ($this->using) 
		{
			return 'USIGN '.join(', ', $this->using);
		}
		elseif ($this->column AND $this->operator AND $this->foreign_column)
		{
			return "ON {$this->column} {$this->operator} {$this->foreign_column}";
		}
		else
		{
			return '';
		}
	}

	public function compile($humanized = FALSE)
	{
		return "JOIN {$this->table} ".$this->compile_condition();
	}
}