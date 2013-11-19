<?php
namespace Openbuildings\Cherry;

class Statement_Limit extends Statement {

	protected $value;

	public function __construct($value = 0)
	{
		$this->value($value);
	}

	public function value($value = NULL)
	{
		if ($value !== NULL)
		{
			$this->value = (int) $value;
			return $this;
		}
		return $this->value;
	}

	public function compile($humanized = FALSE)
	{
		return 'LIMIT '.$this->value;
	}
}