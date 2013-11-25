<?php
namespace Openbuildings\Cherry;

class Statement_Condition_Group extends Statement {

	protected $parent;

	public function __construct($keyword, Statement_Condition_Group $parent = NULL)
	{
		parent::__construct($keyword);
		$this->parent = $parent;
	}

	public function parent()
	{
		return $this->parent;
	}
}