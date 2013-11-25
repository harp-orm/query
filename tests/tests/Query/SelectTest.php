<?php

use Openbuildings\Cherry\Query_Select;
use Openbuildings\Cherry\Statement_Table;
use Openbuildings\Cherry\Statement_Aliased;
use Openbuildings\Cherry\Statement_Column;

/**
 * @group query
 * @group query.select
 */
class Statement_SelectTest extends Testcase_Extended {

	public $select;

	public function setUp()
	{
		parent::setUp();

		$this->select = new Query_Select();
	}

	public function test_distinct()
	{
		$this->select->distinct();

		$expected = array('Query_Select', 'SELECT', array(
			'DISTINCT' => array('Statement', 'DISTINCT'),
		));

		$this->assertStatement($expected, $this->select);
	}

	public function test_construct()
	{
		$select = $this
			->getMockBuilder('Openbuildings\Cherry\Query_Select')
				->setMethods(array('select_array'))
				->disableOriginalConstructor()
				->getMock();

		$select
			->expects($this->once())
			->method('select_array')
			->with($this->equalTo(array('column1', array('column2', 'alias2'))));

		$select->__construct(array('column1', array('column2', 'alias2')));
		$this->assertEquals('SELECT', $select->keyword());
	}

	public function test_select()
	{
		$select = $this->getMock('Openbuildings\Cherry\Query_Select', array('select_array'));

		$select
			->expects($this->once())
			->method('select_array')
			->with($this->equalTo(array('column1', array('column2', 'alias2'))));

		$select->select('column1', array('column2', 'alias2'));
	}

	public function test_select_array()
	{
		$this->select
			->select_array(array('column1', array('column2', 'alias2')));

		$column1 = new Statement_Column('column1');
		$column2 = new Statement_Column('column2');

		$expected = array('Query_Select', 'SELECT', array(
			'SELECT' => array('Statement_List', NULL, array(
				$column1,
				array('Statement_Aliased', NULL, NULL, array(
					'statement' => $column2,
					'alias' => 'alias2',
				)),
			)),
		));

		$this->assertStatement($expected, $this->select);
	}

	public function test_join()
	{
		$this->select
			->join('table1', 'LEFT')
			->on('column1', '=', 'column2')
			->join('table2')
			->on('column2', '=', 'column1')
			->join(array('table3', 'alais3'))
			->using(array('column1', 'column2'));

		$column1 = new Statement_Column('column1');
		$column2 = new Statement_Column('column2');
		$table1 = new Statement_Table('table1');
		$table2 = new Statement_Table('table2');
		$table3 = new Statement_Aliased(new Statement_Table('table3'), 'alais3');

		$expected = array('Query_Select', 'SELECT', array(
			'JOIN' => array('Statement', NULL, array(
				array('Statement_Join', 'JOIN', NULL, array(
					'table' => $table1,
					'column' => $column1,
					'foreign_column' => $column2,
					'operator' => '=',
					'type' => 'LEFT',
				)),
				array('Statement_Join', 'JOIN', NULL, array(
					'table' => $table2,
					'column' => $column2,
					'foreign_column' => $column1,
					'operator' => '=',
					'type' => NULL,
				)),
				array('Statement_Join', 'JOIN', NULL, array(
					'table' => $table3,
					'using' => array($column1, $column2),
					'type' => NULL,
				)),
			)),
		));

		$this->assertStatement($expected, $this->select);
	}

	public function test_group_by()
	{
		$this->select
			->group_by('column1')
			->group_by('column2', 'ASC')
			->group_by('column3', 'DESC');

		$column1 = new Statement_Column('column1');
		$column2 = new Statement_Column('column2');
		$column3 = new Statement_Column('column3');

		$expected = array('Query_Select', 'SELECT', array(
			'GROUP BY' => array('Statement_List', 'GROUP BY', array(
				array('Statement_Direction', NULL, NULL, array(
					'direction' => NULL,
					'column' => $column1
				)),
				array('Statement_Direction', NULL, NULL, array(
					'direction' => 'ASC',
					'column' => $column2
				)),
				array('Statement_Direction', NULL, NULL, array(
					'direction' => 'DESC',
					'column' => $column3
				)),
			)),
		));

		$this->assertStatement($expected, $this->select);
	}

	public function test_having()
	{
		$this->select
			->having('column1', '=', 'value1')
			->or_having('column2', 'IN', array(1, 4));

		$column1 = new Statement_Column('column1');
		$column2 = new Statement_Column('column2');

		$expected = array('Query_Select', 'SELECT', array(
			'HAVING' => array('Statement_Condition_Group', 'HAVING', array(
				array('Statement_Condition', 'AND', NULL, array(
					'operator' => '=',
					'column' => $column1,
					'value' => 'value1',
				)),
				array('Statement_Condition', 'OR', NULL, array(
					'operator' => 'IN',
					'column' => $column2,
					'value' => array(1, 4),
				)),
			)),
		));

		$this->assertStatement($expected, $this->select);
	}

	public function test_nested()
	{
		$this->select
			->having('column1', '=', 'value1')

			->having_open()
				->having('column2', '!=', 'value2')
				->or_having('column3', '>', 'value3')
			->having_close()

			->or_having_open()
				->having('column1', 'IN', 'value1')

				->and_having_open()
					->having('column2', '!=', 'value2')
				->and_having_close()

			->or_having_close();

		$column1 = new Statement_Column('column1');
		$column2 = new Statement_Column('column2');
		$column3 = new Statement_Column('column3');

		$expected = array('Query_Select', 'SELECT', array(
			'HAVING' => array('Statement_Condition_Group', 'HAVING', array(
				array('Statement_Condition', 'AND', NULL, array(
					'operator' => '=',
					'column' => $column1,
					'value' => 'value1',
				)),
				array('Statement_Condition_Group', 'AND', array(
					array('Statement_Condition', 'AND', NULL, array(
						'operator' => '!=',
						'column' => $column2,
						'value' => 'value2',
					)),
					array('Statement_Condition', 'OR', NULL, array(
						'operator' => '>',
						'column' => $column3,
						'value' => 'value3',
					)),
				)),
				array('Statement_Condition_Group', 'OR', array(
					array('Statement_Condition', 'AND', NULL, array(
						'operator' => 'IN',
						'column' => $column1,
						'value' => 'value1',
					)),
					array('Statement_Condition_Group', 'AND', array(
						array('Statement_Condition', 'AND', NULL, array(
							'operator' => '!=',
							'column' => $column2,
							'value' => 'value2',
						)),
					)),
				)),
			)),
		));

		$this->assertStatement($expected, $this->select);
	}

}