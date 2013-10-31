<?php

use Openbuildings\Cherry\Statement_Select;
use Openbuildings\Cherry\Statement_From;
use Openbuildings\Cherry\Statement_Distinct;
use Openbuildings\Cherry\Statement_Column;
use Openbuildings\Cherry\Statement_Table;

/**
 * @group statement.select
 */
class Statement_SelectTest extends Testcase_Extended {

	public function test_compile()
	{
		$select = new Statement_Select();
		$select->from = new Statement_From();
		$select->from->source = new Statement_Table('products', 'alias');

		$select->and_where('test', '=', 'value');
		$select
			->and_where_open()
				->and_where('type', '>', '10')
				->and_where('type', '<', '20')
				->and_where('base', 'IN', array('1', '2', '3'))
			->and_where_close();

		echo $select->compile();
		print_r($select->parameters());
	}
}