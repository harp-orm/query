<?php

use Openbuildings\Cherry\Query_Insert;
use Openbuildings\Cherry\Query_Select;
use Openbuildings\Cherry\Query;
use Openbuildings\Cherry\SQL_Aliased;
use Openbuildings\Cherry\SQL_Join;
use Openbuildings\Cherry\SQL_Condition;
use Openbuildings\Cherry\SQL_Direction;
use Openbuildings\Cherry\SQL_Values;
use Openbuildings\Cherry\SQL_Set;

/**
 * @group sql.insert
 */
class Query_InsertTest extends Testcase_Extended {

	/**
	 * @covers Openbuildings\Cherry\Query_Insert::type
	 */
	public function testType()
	{
		$query = new Query_Insert;

		$query->type('IGNORE');

		$this->assertEquals('IGNORE', $query->children(Query::TYPE));
	}

	/**
	 * @covers Openbuildings\Cherry\Query_Insert::into
	 */
	public function testInto()
	{
		$query = new Query_Insert;

		$query->into('posts');

		$this->assertEquals('posts', $query->children(Query::TABLE));
	}

	/**
	 * @covers Openbuildings\Cherry\Query_Insert::columns
	 */
	public function testColumns()
	{
		$query = new Query_Insert;

		$query->columns('posts');

		$this->assertEquals(array('posts'), $query->children(Query::COLUMNS));

		$query->columns(array('col1', 'col2'));

		$this->assertEquals(array('posts', 'col1', 'col2'), $query->children(Query::COLUMNS));
	}

	/**
	 * @covers Openbuildings\Cherry\Query_Insert::values
	 */
	public function testValues()
	{
		$query = new Query_Insert;

		$query
			->values(array(10, 20))
			->values(array(16, 26));

		$expected = array(
			new SQL_Values(array(10, 20)),
			new SQL_Values(array(16, 26)),
		);

		$this->assertEquals($expected, $query->children(Query::VALUES));
	}

	/**
	 * @covers Openbuildings\Cherry\Query_Insert::set
	 */
	public function testSet()
	{
		$query = new Query_Insert;

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
	 * @covers Openbuildings\Cherry\Query_Insert::select
	 */
	public function testSelect()
	{
		$select = new Query_Select;
		$query = new Query_Insert;

		$query->select($select);

		$this->assertSame($select, $query->children(Query::SELECT));
	}

}