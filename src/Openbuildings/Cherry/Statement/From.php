<?php
namespace Openbuildings\Cherry;

class Statement_From extends Statement {

	public $source;

	public function compile()
	{
		return 'FROM'.($this->source ? ' '.$this->source->compile() : '');
	}
}