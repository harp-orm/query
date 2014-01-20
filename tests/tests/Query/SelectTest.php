<?php

use Openbuildings\Cherry\Query_Select;
use Openbuildings\Cherry\SQL_Condition;
use Openbuildings\Cherry\Query;
use Openbuildings\Cherry\SQL_Join;

/**
 * @group sql.select
 */
class Query_SelectTest extends Testcase_Extended {

	/**
	 * @covers Openbuildings\Cherry\Query_Select::type
	 */
	public function testType()
	{
		$query = new Query_Select;

		$query->type('IGNORE');

		$this->assertEquals('IGNORE', $query->children(Query::TYPE));
	}

	/**
	 * @covers Openbuildings\Cherry\Query_Select::columns
	 */
	public function testColumns()
	{
		$query = $this->getMock('Openbuildings\Cherry\Query_Select', array('addChildrenObjects'));
		$query
			->expects($this->once())
			->method('addChildrenObjects')
			->with(
				$this->equalTo(Query::COLUMNS),
				$this->equalTo(array('column1', 'column2' => 'alias2')),
				$this->equalTo('alias'),
				'Openbuildings\Cherry\SQL_Aliased::factory'
			);

		$query->columns(array('column1', 'column2' => 'alias2'), 'alias');
	}

	/**
	 * @covers Openbuildings\Cherry\Query_Select::from
	 */
	public function testFrom()
	{
		$query = $this->getMock('Openbuildings\Cherry\Query_Select', array('addChildrenObjects'));
		$query
			->expects($this->once())
			->method('addChildrenObjects')
			->with(
				$this->equalTo(Query::FROM),
				$this->equalTo(array('table1', 'table2' => 'alias2')),
				$this->equalTo('alias'),
				'Openbuildings\Cherry\SQL_Aliased::factory'
			);

		$query->from(array('table1', 'table2' => 'alias2'), 'alias');
	}

	/**
	 * @covers Openbuildings\Cherry\Query_Select::join
	 */
	public function testJoin()
	{
		$query = new Query_Select;

		$query
			->join('table1', array('col' => 'col2'))
			->join(array('table2', 'alias2'), 'USING (col1)', 'LEFT');

		$expected = array(
			new SQL_Join('table1', array('col' => 'col2')),
			new SQL_Join(array('table2', 'alias2'), 'USING (col1)', 'LEFT'),
		);

		$this->assertEquals($expected, $query->children(Query::JOIN));
	}

	/**
	 * @covers Openbuildings\Cherry\Query_Select::where
	 */
	public function testWhere()
	{
		$query = new Query_Select;

		$query
			->where(array('test' => 20))
			->where('column = ? OR column = ?', 10, 20);

		$expected = array(
			new SQL_Condition(array('test' => 20)),
			new SQL_Condition('column = ? OR column = ?', array(10, 20)),
		);

		$this->assertEquals($expected, $query->children(Query::WHERE));
	}

	/**
	 * @covers Openbuildings\Cherry\Query_Select::group
	 */
	public function testGroup()
	{
		$query = $this->getMock('Openbuildings\Cherry\Query_Select', array('addChildrenObjects'));
		$query
			->expects($this->once())
			->method('addChildrenObjects')
			->with(
				$this->equalTo(Query::GROUP_BY),
				$this->equalTo(array('column1', 'column2' => 'alias2')),
				$this->equalTo('direction'),
				'Openbuildings\Cherry\SQL_Direction::factory'
			);

		$query->group(array('column1', 'column2' => 'alias2'), 'direction');
	}

	/**
	 * @covers Openbuildings\Cherry\Query_Select::having
	 */
	public function testHaving()
	{
		$query = new Query_Select;

		$query
			->having(array('test' => 20))
			->having('column = ? OR column = ?', 10, 20);

		$expected = array(
			new SQL_Condition(array('test' => 20)),
			new SQL_Condition('column = ? OR column = ?', array(10, 20)),
		);

		$this->assertEquals($expected, $query->children(Query::HAVING));
	}

	/**
	 * @covers Openbuildings\Cherry\Query_Select::order
	 */
	public function testOrder()
	{
		$query = $this->getMock('Openbuildings\Cherry\Query_Select', array('addChildrenObjects'));
		$query
			->expects($this->once())
			->method('addChildrenObjects')
			->with(
				$this->equalTo(Query::ORDER_BY),
				$this->equalTo(array('column1', 'column2' => 'alias2')),
				$this->equalTo('direction'),
				'Openbuildings\Cherry\SQL_Direction::factory'
			);

		$query->order(array('column1', 'column2' => 'alias2'), 'direction');
	}

	/**
	 * @covers Openbuildings\Cherry\Query_Select::limit
	 */
	public function testLimit()
	{
		$query = new Query_Select;

		$query->limit(20);

		$this->assertEquals(20, $query->children(Query::LIMIT));
	}

	/**
	 * @covers Openbuildings\Cherry\Query_Select::offset
	 */
	public function testOffset()
	{
		$query = new Query_Select;

		$query->offset(20);

		$this->assertEquals(20, $query->children(Query::OFFSET));
	}

	/**
	 * @covers Openbuildings\Cherry\Query_Select::sql
	 */
	public function testSql()
	{
		$query = new Query_Select;

		$query
			->from('table1')
			->where(array('name' => 10));

		$this->assertEquals('SELECT * FROM table1 WHERE (name = ?)', $query->sql());
	}
}
