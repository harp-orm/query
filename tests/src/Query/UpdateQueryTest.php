<?php namespace CL\Atlas\Test\Query;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\Query\Query;
use CL\Atlas\Query\UpdateQuery;
use CL\Atlas\SQL\AliasedSQL;
use CL\Atlas\SQL\ConditionSQL;
use CL\Atlas\SQL\DirectionSQL;
use CL\Atlas\SQL\JoinSQL;
use CL\Atlas\SQL\SetSQL;

/**
 * @group query.update
 */
class UpdateQueryTest extends AbstractTestCase {

	/**
	 * @covers CL\Atlas\Query\UpdateQuery::type
	 */
	public function testType()
	{
		$query = new UpdateQuery;

		$query->type('IGNORE');

		$this->assertEquals('IGNORE', $query->children(Query::TYPE));
	}

	/**
	 * @covers CL\Atlas\Query\UpdateQuery::table
	 */
	public function testTable()
	{
		$query = $this->getMock('CL\Atlas\Query\UpdateQuery', array('addChildrenObjects'));
		$query
			->expects($this->once())
			->method('addChildrenObjects')
			->with(
				$this->equalTo(Query::TABLE),
				$this->equalTo(array('table1', 'table2' => 'alias2')),
				$this->equalTo('alias'),
				'CL\Atlas\SQL\AliasedSQL::factory'
			);

		$query->table(array('table1', 'table2' => 'alias2'), 'alias');
	}

	/**
	 * @covers CL\Atlas\Query\UpdateQuery::join
	 */
	public function testJoin()
	{
		$query = new UpdateQuery;

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
	 * @covers CL\Atlas\Query\UpdateQuery::set
	 */
	public function testSet()
	{
		$query = new UpdateQuery;

		$query
			->set(array('test' => 20, 'value' => 10))
			->set(array('name' => 'test'));

		$expected = array(
			new SetSQL('test', 20),
			new SetSQL('value', 10),
			new SetSQL('name', 'test'),
		);

		$this->assertEquals($expected, $query->children(Query::SET));
	}

	/**
	 * @covers CL\Atlas\Query\UpdateQuery::where
	 */
	public function testWhere()
	{
		$query = new UpdateQuery;

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
	 * @covers CL\Atlas\Query\UpdateQuery::order
	 */
	public function testOrder()
	{
		$query = $this->getMock('CL\Atlas\Query\UpdateQuery', array('addChildrenObjects'));
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
	 * @covers CL\Atlas\Query\UpdateQuery::limit
	 */
	public function testLimit()
	{
		$query = new UpdateQuery;

		$query->limit(20);

		$this->assertEquals(20, $query->children(Query::LIMIT));
	}

	/**
	 * @covers CL\Atlas\Query\UpdateQuery::sql
	 */
	public function testSql()
	{
		$query = new UpdateQuery;

		$query
			->table('table1')
			->set(array('name' => 10));

		$this->assertEquals('UPDATE table1 SET name = ?', $query->sql());
	}
}
