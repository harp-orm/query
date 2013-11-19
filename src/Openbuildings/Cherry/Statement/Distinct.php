<?php
namespace Openbuildings\Cherry;

class Statement_Distinct extends Statement {

	public function compile($humanized = FALSE)
	{
		return 'DISTINCT';
	}
}