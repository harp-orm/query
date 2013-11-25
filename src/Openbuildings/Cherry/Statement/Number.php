<?php
namespace Openbuildings\Cherry;

class Statement_Number extends Statement {

	protected $number = NULL;

	public function __construct($keyword = NULL, $number = NULL)
	{
		parent::__construct($keyword);
		
		$this->number = $number;
	}

	public function number()
	{
		return $this->number;
	}
}