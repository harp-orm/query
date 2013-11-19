<?php
namespace Openbuildings\Cherry;

class Statement_Having extends Statement_Condition_Group {

	public function compile($humanized = FALSE)
	{
		return ( ! $this->parent ? 'HAVING ' : '').parent::compile($humanized);
	}
}