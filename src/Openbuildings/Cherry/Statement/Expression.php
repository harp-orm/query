<?php
namespace Openbuildings\Cherry;

class Statement_Expression extends Statement {

	protected $parameters;
	protected $content;

	function __construct($content, array $parameters = NULL)
	{
		$this->parameters = (array) $parameters;
		
		parent::__construct($content);
	}

	public function parameters()
	{
		return $this->parameters;
	}
}