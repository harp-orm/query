<?php

use Openbuildings\Cherry\Query_Update;
use Openbuildings\Cherry\Query;
use Openbuildings\Cherry\SQL_Aliased;
use Openbuildings\Cherry\SQL_Join;
use Openbuildings\Cherry\SQL_Condition;
use Openbuildings\Cherry\SQL_Direction;
use Openbuildings\Cherry\SQL_Set;

/**
 * @group sql.update
 */
class Query_UpdateTest extends Testcase_Extended {

	/**
	 * @covers Openbuildings\Cherry\Query_Update::type
	 */
	public function testType()
	{
		$query = new Query_Update;

		$query->type('IGNORE');

		$this->assertEquals('IGNORE', $query->children(Query::TYPE));
	}

	/**
	 * @covers Openbuildings\Cherry\Query_Update::table
	 */
	public function testTable()
	{
		$query = $this->getMock('Openbuildings\Cherry\Query_Update', array('addChildrenObjects'));
		$query
			->expects($this->once())
			->method('addChildrenObjects')
			->with(
				$this->equalTo(Query::TABLE),
				$this->equalTo(array('table1', 'table2' => 'alias2')),
				$this->equalTo('alias'),
				'Openbuildings\Cherry\SQL_Aliased::factory'
			);

		$query->table(array('table1', 'table2' => 'alias2'), 'alias');
	}

	/**
	 * @covers Openbuildings\Cherry\Query_Update::join
	 */
	public function testJoin()
	{
		$query = new Query_Update;

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
	 * @covers Openbuildings\Cherry\Query_Update::set
	 */
	public function testSet()
	{
		$query = new Query_Update;

		$query
			->set(array('test' => 20, 'value' => 10))
			->set(array('name' => 'test'));

		$expected = array(
			new SQL_Set('test', 20),
			new SQL_Set('value', 10),
			new SQL_Set('name', 'test'),
		);

		$this->assertEquals($expected, $query->children(Query::SET));
	}

	/**
	 * @covers Openbuildings\Cherry\Query_Update::where
	 */
	public function testWhere()
	{
		$query = new Query_Update;

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
	 * @covers Openbuildings\Cherry\Query_Update::order
	 */
	public function testOrder()
	{
		$query = $this->getMock('Openbuildings\Cherry\Query_Update', array('addChildrenObjects'));
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
	 * @covers Openbuildings\Cherry\Query_Update::limit
	 */
	public function testLimit()
	{
		$query = new Query_Update;

		$query->limit(20);

		$this->assertEquals(20, $query->children(Query::LIMIT));
	}

	/**
	 * @covers Openbuildings\Cherry\Query_Update::sql
	 */
	public function testSql()
	{
		$query = new Query_Update;

		$query
			->table('table1')
			->set(array('name' => 10));

		$this->assertEquals('UPDATE table1 SET name = ?', $query->sql());
	}
}
