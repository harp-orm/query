<?php
namespace Openbuildings\Cherry;

class Statement_Part_Table extends Statement_Part_Aliased {

	public function __construct($name, $alias = NULL)
	{
		parent::__construct($name, $alias);

		if ($this->name instanceof Statement_Select) 
		{
			$this->children []= $this->name;
		}
	}

	public function compile_name()
	{
		return ($this->name instanceof Query_Select) ? "({$this->name->compile()})" : $this->name;
	}
}