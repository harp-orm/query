<?php
namespace Openbuildings\Cherry;

class Statement_Column extends Statement_Aliased {

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
