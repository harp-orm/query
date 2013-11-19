<?php
namespace Openbuildings\Cherry;

class Statement_Part_Expression extends Statement {

	protected $parameters;
	protected $content;

	function __construct($content, array $parameters = NULL)
	{
		$this->parameters = (array) $parameters;
		$this->content = $content;
	}

	public function parameters()
	{
		return $this->parameters;
	}

	public function compile($humanized = FALSE)
	{
		return $this->content;
	}
}