<?php

use Openbuildings\Cherry\Statement_Column;

/**
 * @group query
 * @group query.where
 */
class Query_WhereTest extends Testcase_Extended {

	public $where;

	public function setUp()
	{
		parent::setUp();

		$this->where = $this->getMockForAbstractClass('Openbuildings\Cherry\Query_Where');
	}

	public function test_limit()
	{
		$this->where->limit(10);

		$expected = array('Query_Where', NULL, array(
			'LIMIT' => array('Statement_Number', 'LIMIT', NULL, array('number' => 10)),
		));

		$this->assertStatement($expected, $this->where);
	}

	public function test_order_by()
	{
		$this->where
			->order_by('column1')
			->order_by('column2', 'ASC')
			->order_by('column3', 'DESC');

		$column1 = new Statement_Column('column1');
		$column2 = new Statement_Column('column2');
		$column3 = new Statement_Column('column3');

		$expected = array('Query_Where', NULL, array(
			'ORDER BY' => array('Statement_List', 'ORDER BY', array(
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

		$this->assertStatement($expected, $this->where);
	}

	public function test_where()
	{
		$this->where
			->where('column1', '=', 'value1')
			->or_where('column2', 'IN', array(1, 4));

		$column1 = new Statement_Column('column1');
		$column2 = new Statement_Column('column2');

		$expected = array('Query_Where', NULL, array(
			'WHERE' => array('Statement_Condition_Group', 'WHERE', array(
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

		$this->assertStatement($expected, $this->where);
	}

	public function test_nested()
	{
		$this->where
			->where('column1', '=', 'value1')

			->where_open()
				->where('column2', '!=', 'value2')
				->or_where('column3', '>', 'value3')
			->where_close()

			->or_where_open()
				->where('column1', 'IN', 'value1')

				->and_where_open()
					->where('column2', '!=', 'value2')
				->and_where_close()

			->or_where_close();

		$column1 = new Statement_Column('column1');
		$column2 = new Statement_Column('column2');
		$column3 = new Statement_Column('column3');

		$expected = array('Query_Where', NULL, array(
			'WHERE' => array('Statement_Condition_Group', 'WHERE', array(
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

		$this->assertStatement($expected, $this->where);
	}

}