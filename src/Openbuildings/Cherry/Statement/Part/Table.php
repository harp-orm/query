<?php
namespace Openbuildings\Cherry;

class Statement_Part_Table extends Statement_Part_Aliased {

	public function __construct($name, $alias = NULL)
	{
		parent::__construct($name, $alias);

		$this->children []= $this->name;
	}

	public function compile_name($humanized = FALSE)
	{
		if ($this->name instanceof Query_Select) 
		{
			return $humanized 
				? Statement::indent("(\n".Statement::indent($this->name->compile($humanized))."\n)")
				: "({$this->name})";
		}
		else
		{
			return $humanized 
				? Statement::indent($this->name)
				: $this->name;
		}
	}
}