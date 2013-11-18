<?php
namespace Openbuildings\Cherry;

class Statement_Having extends Statement_Condition_Group {

	public function compile()
	{
		return ( ! $this->parent ? 'HAVING ' : '').parent::compile();
	}
}