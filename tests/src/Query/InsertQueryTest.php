<?php namespace CL\Atlas\Test\Query;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\Query\Query;
use CL\Atlas\Query\InsertQuery;
use CL\Atlas\Query\SelectQuery;
use CL\Atlas\SQL\AliasedSQL;
use CL\Atlas\SQL\JoinSQL;
use CL\Atlas\SQL\ConditionSQL;
use CL\Atlas\SQL\DirectionSQL;
use CL\Atlas\SQL\ValuesSQL;
use CL\Atlas\SQL\SetSQL;

/**
 * @group sql.insert
 */
class InsertQueryTest extends AbstractTestCase {

	/**
	 * @covers CL\Atlas\Query\InsertQuery::type
	 */
	public function testType()
	{
		$query = new InsertQuery;

		$query->type('IGNORE');

		$this->assertEquals('IGNORE', $query->children(Query::TYPE));
	}

	/**
	 * @covers CL\Atlas\Query\InsertQuery::into
	 */
	public function testInto()
	{
		$query = new InsertQuery;

		$query->into('posts');

		$this->assertEquals('posts', $query->children(Query::TABLE));
	}

	/**
	 * @covers CL\Atlas\Query\InsertQuery::columns
	 */
	public function testColumns()
	{
		$query = new InsertQuery;

		$query->columns('posts');

		$this->assertEquals(array('posts'), $query->children(Query::COLUMNS));

		$query->columns(array('col1', 'col2'));

		$this->assertEquals(array('posts', 'col1', 'col2'), $query->children(Query::COLUMNS));
	}

	/**
	 * @covers CL\Atlas\Query\InsertQuery::values
	 */
	public function testValues()
	{
		$query = new InsertQuery;

		$query
			->values(array(10, 20))
			->values(array(16, 26));

		$expected = array(
			new ValuesSQL(array(10, 20)),
			new ValuesSQL(array(16, 26)),
		);

		$this->assertEquals($expected, $query->children(Query::VALUES));
	}

	/**
	 * @covers CL\Atlas\Query\InsertQuery::set
	 */
	public function testSet()
	{
		$query = new InsertQuery;

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
	 * @covers CL\Atlas\Query\InsertQuery::select
	 */
	public function testSelect()
	{
		$select = new SelectQuery;
		$query = new InsertQuery;

		$query->select($select);

		$this->assertSame($select, $query->children(Query::SELECT));
	}

	/**
	 * @covers CL\Atlas\Query\InsertQuery::sql
	 */
	public function testSql()
	{
		$query = new InsertQuery;

		$query
			->into('table1')
			->set(array('name' => 10));

		$this->assertEquals('INSERT INTO table1 SET name = ?', $query->sql());
	}
}
