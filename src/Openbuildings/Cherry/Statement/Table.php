<?php
namespace Openbuildings\Cherry;

class Statement_Table extends Statement {

	protected $name;

	public function __construct($name)
	{
		$this->name = $name;
		$this->children []= $name;
	}

	public function name()
	{
		return $this->name;
	}

}
