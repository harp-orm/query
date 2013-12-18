<?php

use Openbuildings\Cherry\Query_Delete;
use Openbuildings\Cherry\Statement_Table;
use Openbuildings\Cherry\Statement_Expression;
use Openbuildings\Cherry\Statement_Aliased;
use Openbuildings\Cherry\Statement_Column;

/**
 * @group query
 * @group query.delete
 */
class Query_DeleteTest extends Testcase_Extended {

	public $delete;

	public function setUp()
	{
		parent::setUp();

		$this->delete = new Query_Delete;
	}

	/**
	 * @covers Openbuildings\Cherry\Query_Delete::only
	 */
	public function test_only()
	{
		$this->delete
			->only('table1', 'table2');

		$table1 = new Statement_Table('table1');
		$table2 = new Statement_Table('table2');

		$expected = array('Query_Delete', 'DELETE', array(
			'ONLY' => array('Statement_List', NULL, array(
				$table1,
				$table2,
			)),
		));

		$this->assertStatement($expected, $this->delete);
	}

	/**
	 * @covers Openbuildings\Cherry\Query_Delete::from
	 */
	public function test_from()
	{
		$this->delete
			->from('table1', array('table2', 'alias2'));

		$table1 = new Statement_Table('table1');
		$table2 = new Statement_Table('table2');

		$expected = array('Query_Delete', 'DELETE', array(
			'FROM' => array('Statement_List', 'FROM', array(
				$table1,
				array('Statement_Aliased', NULL, NULL, array(
					'statement' => $table2,
					'alias' => 'alias2',
				)),
			)),
		));

		$this->assertStatement($expected, $this->delete);
	}
}