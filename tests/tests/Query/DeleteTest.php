<?php

use Openbuildings\Cherry\Query_Delete;
use Openbuildings\Cherry\Query;
use Openbuildings\Cherry\SQL_Aliased;
use Openbuildings\Cherry\SQL_Join;
use Openbuildings\Cherry\SQL_Condition;
use Openbuildings\Cherry\SQL_Direction;

/**
 * @group sql.delete
 */
class Query_DeleteTest extends Testcase_Extended {

	/**
	 * @covers Openbuildings\Cherry\Query_Delete::type
	 */
	public function testType()
	{
		$query = new Query_Delete;

		$query->type('IGNORE');

		$this->assertEquals('IGNORE', $query->children(Query::TYPE));

		$query->type('IGNORE QUICK');

		$this->assertEquals('IGNORE QUICK', $query->children(Query::TYPE));
	}

	/**
	 * @covers Openbuildings\Cherry\Query_Delete::table
	 */
	public function testTable()
	{
		$query = $this->getMock('Openbuildings\Cherry\Query_Delete', array('addChildren'));
		$query
			->expects($this->at(0))
			->method('addChildren')
			->with($this->equalTo(Query::TABLE), $this->equalTo(array('table1')));

		$query
			->expects($this->at(1))
			->method('addChildren')
			->with($this->equalTo(Query::TABLE), $this->equalTo(array('table1', 'table2')));

		$query->table('table1');
		$query->table(array('table1', 'table2'));
	}

	/**
	 * @covers Openbuildings\Cherry\Query_Delete::from
	 */
	public function testFrom()
	{
		$query = $this->getMock('Openbuildings\Cherry\Query_Delete', array('addChildrenObjects'));
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
	 * @covers Openbuildings\Cherry\Query_Delete::join
	 */
	public function testJoin()
	{
		$query = new Query_Delete;

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
	 * @covers Openbuildings\Cherry\Query_Delete::where
	 */
	public function testWhere()
	{
		$query = new Query_Delete;

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
	 * @covers Openbuildings\Cherry\Query_Delete::order
	 */
	public function testOrder()
	{
		$query = $this->getMock('Openbuildings\Cherry\Query_Delete', array('addChildrenObjects'));
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
	 * @covers Openbuildings\Cherry\Query_Delete::limit
	 */
	public function testLimit()
	{
		$query = new Query_Delete;

		$query->limit(20);

		$this->assertEquals(20, $query->children(Query::LIMIT));
	}

	/**
	 * @covers Openbuildings\Cherry\Query_Delete::sql
	 */
	public function testSql()
	{
		$query = new Query_Delete;

		$query
			->from('table1')
			->limit(10);

		$this->assertEquals('DELETE FROM table1 LIMIT 10', $query->sql());
	}
}
