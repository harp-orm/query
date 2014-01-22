<?php namespace Openbuildings\Cherry\Test\Query;

use Openbuildings\Cherry\TestCase;
use Openbuildings\Cherry\Query\Query;
use Openbuildings\Cherry\Query\SelectQuery;
use Openbuildings\Cherry\SQL\ConditionSQL;
use Openbuildings\Cherry\SQL\JoinSQL;

/**
 * @group sql.select
 */
class SelectQueryTest extends TestCase {

	/**
	 * @covers Openbuildings\Cherry\Query\SelectQuery::type
	 */
	public function testType()
	{
		$query = new SelectQuery;

		$query->type('IGNORE');

		$this->assertEquals('IGNORE', $query->children(Query::TYPE));
	}

	/**
	 * @covers Openbuildings\Cherry\Query\SelectQuery::columns
	 */
	public function testColumns()
	{
		$query = $this->getMock('Openbuildings\Cherry\Query\SelectQuery', array('addChildrenObjects'));
		$query
			->expects($this->once())
			->method('addChildrenObjects')
			->with(
				$this->equalTo(Query::COLUMNS),
				$this->equalTo(array('column1', 'column2' => 'alias2')),
				$this->equalTo('alias'),
				'Openbuildings\Cherry\SQL\AliasedSQL::factory'
			);

		$query->columns(array('column1', 'column2' => 'alias2'), 'alias');
	}

	/**
	 * @covers Openbuildings\Cherry\Query\SelectQuery::from
	 */
	public function testFrom()
	{
		$query = $this->getMock('Openbuildings\Cherry\Query\SelectQuery', array('addChildrenObjects'));
		$query
			->expects($this->once())
			->method('addChildrenObjects')
			->with(
				$this->equalTo(Query::FROM),
				$this->equalTo(array('table1', 'table2' => 'alias2')),
				$this->equalTo('alias'),
				'Openbuildings\Cherry\SQL\AliasedSQL::factory'
			);

		$query->from(array('table1', 'table2' => 'alias2'), 'alias');
	}

	/**
	 * @covers Openbuildings\Cherry\Query\SelectQuery::join
	 */
	public function testJoin()
	{
		$query = new SelectQuery;

		$query
			->join('table1', array('col' => 'col2'))
			->join(array('table2', 'alias2'), 'USING (col1)', 'LEFT');

		$expected = array(
			new JoinSQL('table1', array('col' => 'col2')),
			new JoinSQL(array('table2', 'alias2'), 'USING (col1)', 'LEFT'),
		);

		$this->assertEquals($expected, $query->children(Query::JOIN));
	}

	/**
	 * @covers Openbuildings\Cherry\Query\SelectQuery::where
	 */
	public function testWhere()
	{
		$query = new SelectQuery;

		$query
			->where(array('test' => 20))
			->where('column = ? OR column = ?', 10, 20);

		$expected = array(
			new ConditionSQL(array('test' => 20)),
			new ConditionSQL('column = ? OR column = ?', array(10, 20)),
		);

		$this->assertEquals($expected, $query->children(Query::WHERE));
	}

	/**
	 * @covers Openbuildings\Cherry\Query\SelectQuery::group
	 */
	public function testGroup()
	{
		$query = $this->getMock('Openbuildings\Cherry\Query\SelectQuery', array('addChildrenObjects'));
		$query
			->expects($this->once())
			->method('addChildrenObjects')
			->with(
				$this->equalTo(Query::GROUP_BY),
				$this->equalTo(array('column1', 'column2' => 'alias2')),
				$this->equalTo('direction'),
				'Openbuildings\Cherry\SQL\DirectionSQL::factory'
			);

		$query->group(array('column1', 'column2' => 'alias2'), 'direction');
	}

	/**
	 * @covers Openbuildings\Cherry\Query\SelectQuery::having
	 */
	public function testHaving()
	{
		$query = new SelectQuery;

		$query
			->having(array('test' => 20))
			->having('column = ? OR column = ?', 10, 20);

		$expected = array(
			new ConditionSQL(array('test' => 20)),
			new ConditionSQL('column = ? OR column = ?', array(10, 20)),
		);

		$this->assertEquals($expected, $query->children(Query::HAVING));
	}

	/**
	 * @covers Openbuildings\Cherry\Query\SelectQuery::order
	 */
	public function testOrder()
	{
		$query = $this->getMock('Openbuildings\Cherry\Query\SelectQuery', array('addChildrenObjects'));
		$query
			->expects($this->once())
			->method('addChildrenObjects')
			->with(
				$this->equalTo(Query::ORDER_BY),
				$this->equalTo(array('column1', 'column2' => 'alias2')),
				$this->equalTo('direction'),
				'Openbuildings\Cherry\SQL\DirectionSQL::factory'
			);

		$query->order(array('column1', 'column2' => 'alias2'), 'direction');
	}

	/**
	 * @covers Openbuildings\Cherry\Query\SelectQuery::limit
	 */
	public function testLimit()
	{
		$query = new SelectQuery;

		$query->limit(20);

		$this->assertEquals(20, $query->children(Query::LIMIT));
	}

	/**
	 * @covers Openbuildings\Cherry\Query\SelectQuery::offset
	 */
	public function testOffset()
	{
		$query = new SelectQuery;

		$query->offset(20);

		$this->assertEquals(20, $query->children(Query::OFFSET));
	}

	/**
	 * @covers Openbuildings\Cherry\Query\SelectQuery::sql
	 */
	public function testSql()
	{
		$query = new SelectQuery;

		$query
			->from('table1')
			->where(array('name' => 10));

		$this->assertEquals('SELECT * FROM table1 WHERE (name = ?)', $query->sql());
	}
}
