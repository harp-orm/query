<?php namespace Openbuildings\Cherry\Test\Query;

use Openbuildings\Cherry\Test\TestCase;
use Openbuildings\Cherry\Query\Query;
use Openbuildings\Cherry\Query\InsertQuery;
use Openbuildings\Cherry\Query\SelectQuery;
use Openbuildings\Cherry\SQL\AliasedSQL;
use Openbuildings\Cherry\SQL\JoinSQL;
use Openbuildings\Cherry\SQL\ConditionSQL;
use Openbuildings\Cherry\SQL\DirectionSQL;
use Openbuildings\Cherry\SQL\ValuesSQL;
use Openbuildings\Cherry\SQL\SetSQL;

/**
 * @group sql.insert
 */
class InsertQueryTest extends TestCase {

	/**
	 * @covers Openbuildings\Cherry\Query\InsertQuery::type
	 */
	public function testType()
	{
		$query = new InsertQuery;

		$query->type('IGNORE');

		$this->assertEquals('IGNORE', $query->children(Query::TYPE));
	}

	/**
	 * @covers Openbuildings\Cherry\Query\InsertQuery::into
	 */
	public function testInto()
	{
		$query = new InsertQuery;

		$query->into('posts');

		$this->assertEquals('posts', $query->children(Query::TABLE));
	}

	/**
	 * @covers Openbuildings\Cherry\Query\InsertQuery::columns
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
	 * @covers Openbuildings\Cherry\Query\InsertQuery::values
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
	 * @covers Openbuildings\Cherry\Query\InsertQuery::set
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
	 * @covers Openbuildings\Cherry\Query\InsertQuery::select
	 */
	public function testSelect()
	{
		$select = new SelectQuery;
		$query = new InsertQuery;

		$query->select($select);

		$this->assertSame($select, $query->children(Query::SELECT));
	}

	/**
	 * @covers Openbuildings\Cherry\Query\InsertQuery::sql
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
