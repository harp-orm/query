<?php
namespace Openbuildings\Cherry;

class Statement_Where extends Statement_Condition_Group {

	public function compile()
	{
		return ( ! $this->parent ? 'WHERE ' : '').parent::compile();
	}
}