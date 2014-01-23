<?php namespace CL\Atlas\Test\Query;

use CL\Atlas\Test\TestCase;
use CL\Atlas\Query\Query;
use CL\Atlas\Query\DeleteQuery;
use CL\Atlas\SQL\AliasedSQL;
use CL\Atlas\SQL\JoinSQL;
use CL\Atlas\SQL\ConditionSQL;
use CL\Atlas\SQL\DirectionSQL;

/**
 * @group sql.delete
 */
class DeleteQueryTest extends TestCase {

	/**
	 * @covers CL\Atlas\Query\DeleteQuery::type
	 */
	public function testType()
	{
		$query = new DeleteQuery;

		$query->type('IGNORE');

		$this->assertEquals('IGNORE', $query->children(Query::TYPE));

		$query->type('IGNORE QUICK');

		$this->assertEquals('IGNORE QUICK', $query->children(Query::TYPE));
	}

	/**
	 * @covers CL\Atlas\Query\DeleteQuery::table
	 */
	public function testTable()
	{
		$query = $this->getMock('CL\Atlas\Query\DeleteQuery', array('addChildren'));
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
	 * @covers CL\Atlas\Query\DeleteQuery::from
	 */
	public function testFrom()
	{
		$query = $this->getMock('CL\Atlas\Query\DeleteQuery', array('addChildrenObjects'));
		$query
			->expects($this->once())
			->method('addChildrenObjects')
			->with(
				$this->equalTo(Query::FROM),
				$this->equalTo(array('table1', 'table2' => 'alias2')),
				$this->equalTo('alias'),
				'CL\Atlas\SQL\AliasedSQL::factory'
			);

		$query->from(array('table1', 'table2' => 'alias2'), 'alias');
	}

	/**
	 * @covers CL\Atlas\Query\DeleteQuery::join
	 */
	public function testJoin()
	{
		$query = new DeleteQuery;

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
	 * @covers CL\Atlas\Query\DeleteQuery::where
	 */
	public function testWhere()
	{
		$query = new DeleteQuery;

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
	 * @covers CL\Atlas\Query\DeleteQuery::order
	 */
	public function testOrder()
	{
		$query = $this->getMock('CL\Atlas\Query\DeleteQuery', array('addChildrenObjects'));
		$query
			->expects($this->once())
			->method('addChildrenObjects')
			->with(
				$this->equalTo(Query::ORDER_BY),
				$this->equalTo(array('column1', 'column2' => 'alias2')),
				$this->equalTo('direction'),
				'CL\Atlas\SQL\DirectionSQL::factory'
			);

		$query->order(array('column1', 'column2' => 'alias2'), 'direction');
	}


	/**
	 * @covers CL\Atlas\Query\DeleteQuery::limit
	 */
	public function testLimit()
	{
		$query = new DeleteQuery;

		$query->limit(20);

		$this->assertEquals(20, $query->children(Query::LIMIT));
	}

	/**
	 * @covers CL\Atlas\Query\DeleteQuery::sql
	 */
	public function testSql()
	{
		$query = new DeleteQuery;

		$query
			->from('table1')
			->limit(10);

		$this->assertEquals('DELETE FROM table1 LIMIT 10', $query->sql());
	}
}
