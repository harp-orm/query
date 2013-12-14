<?php

use Openbuildings\Cherry\Query_Update;
use Openbuildings\Cherry\Statement_Table;
use Openbuildings\Cherry\Statement_Expression;
use Openbuildings\Cherry\Statement_Aliased;
use Openbuildings\Cherry\Statement_Column;

/**
 * @group query
 * @group query.update
 */
class Statement_UpdateTest extends Testcase_Extended {

	public $update;

	public function setUp()
	{
		parent::setUp();

		$this->update = new Query_Update;
	}

	public function test_construct()
	{
		$update = $this
			->getMockBuilder('Openbuildings\Cherry\Query_Update')
				->setMethods(array('table'))
				->disableOriginalConstructor()
				->getMock();

		$update
			->expects($this->once())
			->method('table')
			->with($this->equalTo('table1'), $this->equalTo(array('table2', 'alias2')));

		$update->__construct(array('table1', array('table2', 'alias2')));
		$this->assertEquals('UPDATE', $update->keyword());
	}

	public function test_table()
	{
		$this->update
			->table('table1', array('table2', 'alias2'));

		$table1 = new Statement_Table('table1');
		$table2 = new Statement_Table('table2');

		$expected = array('Query_Update', 'UPDATE', array(
			'TABLE' => array('Statement_List', NULL, array(
				$table1,
				array('Statement_Aliased', NULL, NULL, array(
					'statement' => $table2,
					'alias' => 'alias2',
				)),
			)),
		));

		$this->assertStatement($expected, $this->update);
	}

	public function test_set()
	{
		$expr = new Statement_Expression('TEST');
		$this->update
			->set(array(
				'column1' => 'value1',
				'column2' => $expr,
			));

		$column1 = new Statement_Column('column1');
		$column2 = new Statement_Column('column2');

		$expected = array('Query_Update', 'UPDATE', array(
			'SET' => array('Statement_List', 'SET', array(
				array('Statement_Set', NULL, NULL, array(
					'column' => $column1,
					'value' => 'value1',
				)),
				array('Statement_Set', NULL, NULL, array(
					'column' => $column2,
					'value' => $expr,
				)),
			)),
		));

		$this->assertStatement($expected, $this->update);
	}

	public function test_value()
	{
		$expr = new Statement_Expression('TEST');
		$this->update
			->value('column1', 'value1')
			->value('column2', $expr);

		$column1 = new Statement_Column('column1');
		$column2 = new Statement_Column('column2');

		$expected = array('Query_Update', 'UPDATE', array(
			'SET' => array('Statement_List', 'SET', array(
				array('Statement_Set', NULL, NULL, array(
					'column' => $column1,
					'value' => 'value1',
				)),
				array('Statement_Set', NULL, NULL, array(
					'column' => $column2,
					'value' => $expr,
				)),
			)),
		));

		$this->assertStatement($expected, $this->update);
	}
}