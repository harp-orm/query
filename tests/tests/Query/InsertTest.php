<?php

use Openbuildings\Cherry\Query_Insert;
use Openbuildings\Cherry\Query_Select;
use Openbuildings\Cherry\Statement_Table;
use Openbuildings\Cherry\Statement_Expression;
use Openbuildings\Cherry\Statement_Column;

/**
 * @group query
 * @group query.insert
 */
class Query_InsertTest extends Testcase_Extended {

	public $insert;

	public function setUp()
	{
		parent::setUp();

		$this->insert = new Query_Insert;
	}

	/**
	 * @covers Openbuildings\Cherry\Query_Insert::prefix
	 */
	public function test_prefix()
	{
		$this->insert
			->prefix('IGNORE');

		$expected = array('Query_Insert', 'INSERT', array(
			'PREFIX' => array('Statement', 'IGNORE'),
		));

		$this->assertStatement($expected, $this->insert);
	}

	/**
	 * @covers Openbuildings\Cherry\Query_Insert::into
	 */
	public function test_into()
	{
		$this->insert
			->into('table1');

		$expected = array('Query_Insert', 'INSERT', array(
			'INTO' => array('Statement', 'INTO', array(
				array('Statement_Table', NULL, NULL, array(
					'name' => 'table1',
				))
			)),
		));

		$this->assertStatement($expected, $this->insert);
	}

	/**
	 * @covers Openbuildings\Cherry\Query_Insert::columns
	 */
	public function test_columns()
	{
		$this->insert
			->columns('column1', 'column2');

		$expected = array('Query_Insert', 'INSERT', array(
			'COLUMNS' => array('Statement_Insert_Columns', NULL, array(
				array('Statement_Column', NULL, NULL, array('name' => 'column1')),
				array('Statement_Column', NULL, NULL, array('name' => 'column2')),
			)),
		));

		$this->insert
			->columns('column3');

		$expected = array('Query_Insert', 'INSERT', array(
			'COLUMNS' => array('Statement_Insert_Columns', NULL, array(
				array('Statement_Column', NULL, NULL, array('name' => 'column1')),
				array('Statement_Column', NULL, NULL, array('name' => 'column2')),
				array('Statement_Column', NULL, NULL, array('name' => 'column3')),
			)),
		));

		$this->assertStatement($expected, $this->insert);
	}

	/**
	 * @covers Openbuildings\Cherry\Query_Insert::set
	 */
	public function test_set()
	{
		$this->insert
			->set(array('name' => 'new_name', 'id' => 'new_id'));

		$expected = array('Query_Insert', 'INSERT', array(
			'SET' => array('Statement_List', 'SET', array(
				array('Statement_Set', NULL,
					array(array('Statement_Column', NULL, NULL, array('name' => 'name'))), 
					array('value' => 'new_name')
				),
				array('Statement_Set', NULL,
					array(array('Statement_Column', NULL, NULL, array('name' => 'id'))), 
					array('value' => 'new_id')
				),
			)),
		));

		$this->insert
			->set(array('email' => NULL));

			$expected = array('Query_Insert', 'INSERT', array(
				'SET' => array('Statement_List', 'SET', array(
					array('Statement_Set', NULL,
						array(array('Statement_Column', NULL, NULL, array('name' => 'name'))), 
						array('value' => 'new_name')
					),
					array('Statement_Set', NULL,
						array(array('Statement_Column', NULL, NULL, array('name' => 'id'))), 
						array('value' => 'new_id')
					),
					array('Statement_Set', NULL,
						array(array('Statement_Column', NULL, NULL, array('name' => 'email'))), 
						array('value' => NULL)
					),
				)),
			));

		$this->assertStatement($expected, $this->insert);
	}

	/**
	 * @covers Openbuildings\Cherry\Query_Insert::select
	 */
	public function test_select()
	{
		$select = new Query_Select;

		$this->insert
			->select($select);

		$expected = array('Query_Insert', 'INSERT', array(
			'SELECT' => $select,
		));

		$this->assertStatement($expected, $this->insert);
	}

	/**
	 * @covers Openbuildings\Cherry\Query_Insert::values
	 */
	public function test_values()
	{
		$this->insert
			->values(array(1, 'name1'), array(2, 'name2'));

		$expected = array('Query_Insert', 'INSERT', array(
			'VALUES' => array('Statement_List', 'VALUES', array(
				array('Statement_Insert_Values', NULL, array(1, 'name1')),
				array('Statement_Insert_Values', NULL, array(2, 'name2')),
			)),
		));

		$this->insert
			->values(array(3, 'name3'));

		$expected = array('Query_Insert', 'INSERT', array(
			'VALUES' => array('Statement_List', 'VALUES', array(
				array('Statement_Insert_Values', NULL, array(1, 'name1')),
				array('Statement_Insert_Values', NULL, array(2, 'name2')),
				array('Statement_Insert_Values', NULL, array(3, 'name3')),
			)),
		));

		$this->assertStatement($expected, $this->insert);
	}
}