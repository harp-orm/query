<?php
namespace Openbuildings\Cherry;

class Statement_List extends Statement {

	protected $empty_value = NULL;

	public function __construct($keyword = NULL, $children = NULL, $empty_value = NULL)
	{
		parent::__construct($keyword, $children);
		$this->empty_value = $empty_value;
	}

	public function empty_value()
	{
		return $this->empty_value;
	}

	public function children()
	{
		return $this->children ? $this->children : array($this->empty_value);
	}
}