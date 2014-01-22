<?php namespace Openbuildings\Cherry\Test\Query;

use Openbuildings\Cherry\TestCase;
use Openbuildings\Cherry\Query\Query;
use Openbuildings\Cherry\SQL\SQL;
use Openbuildings\Cherry\DB;
use stdClass;
use Openbuildings\Cherry\Test\ParametrisedStub;

/**
 * @group str
 */
class QueryTest extends TestCase {

	public function testConstants()
	{
		$constants = array(
			Query::TYPE,
			Query::TABLE,
			Query::FROM,
			Query::JOIN,
			Query::COLUMNS,
			Query::VALUES,
			Query::SELECT,
			Query::SET,
			Query::WHERE,
			Query::HAVING,
			Query::GROUP_BY,
			Query::ORDER_BY,
			Query::LIMIT,
			Query::OFFSET,
		);

		$this->assertEquals(count($constants), count(array_unique($constants)), 'Should not have repeating values');
	}

	/**
	 * @covers Openbuildings\Cherry\Query\Query::children
	 */
	public function testChildren()
	{
		$children = array(Query::TYPE => 'ignore', Query::LIMIT => 10);

		$query = $this->getMock('Openbuildings\Cherry\Query\Query', array('sql'), array($children));

		$this->assertEquals($children, $query->children());

		$this->assertEquals('ignore', $query->children(Query::TYPE));
		$this->assertEquals(10, $query->children(Query::LIMIT));
		$this->assertEquals(NULL, $query->children('non existant'));
	}

	/**
	 * @covers Openbuildings\Cherry\Query\Query::parameters
	 */
	public function testParameters()
	{
		$object1 = $this->getMock('Openbuildings\Cherry\Test\ParametrisedStub', array('parameters'));
		$object1
			->expects($this->once())
			->method('parameters')
			->will($this->returnValue(array('test1', 'test2', array('test3', 'test4'))));

		$object2 = $this->getMock('Openbuildings\Cherry\Test\ParametrisedStub', array('parameters'));
		$object2
			->expects($this->once())
			->method('parameters')
			->will($this->returnValue(array('test5')));

		$query = $this->getMock('Openbuildings\Cherry\Query\Query', array('sql'), array(array('test', array($object1), $object2)));

		$this->assertEquals(array('test1', 'test2', 'test3', 'test4', 'test5'), $query->parameters());

		$query = $this->getMock('Openbuildings\Cherry\Query\Query', array('sql'));

		$this->assertEquals(array(), $query->parameters());
	}

	/**
	 * @covers Openbuildings\Cherry\Query\Query::addChildren
	 * @covers Openbuildings\Cherry\Query\Query::__construct
	 */
	public function testAddChildren()
	{
		$child1 = new stdClass;
		$child2 = new stdClass;
		$child3 = new stdClass;

		$query = $this->getMock('Openbuildings\Cherry\Query\Query', array('sql'), array(array(Query::TABLE => array($child1))));

		$query->addChildren(Query::TABLE, array($child2));
		$query->addChildren(Query::COLUMNS, array($child3));

		$expected_children = array(
			Query::TABLE => array(
				$child1,
				$child2,
			),
			Query::COLUMNS => array(
				$child3,
			),
		);

		$this->assertEquals($expected_children, $query->children());
	}

	public function dataAddChildrenObjects()
	{
		return array(
			array(
				'test',
				NULL,
				array(array('test', NULL, 'result')),
				array('result')
			),
			array(
				'test',
				'arg',
				array(array('test', 'arg', 'result')),
				array('result')
			),
			array(
				array('test'),
				NULL,
				array(array('test', NULL, 'result')),
				array('result')
			),
			array(
				array('test' => 'arg'),
				NULL,
				array(array('test', 'arg', 'result')),
				array('result')
			),
			array(
				array('test1' => 'arg1', 'test2', 'test3' => 'arg3'),
				NULL,
				array(
					array('test1', 'arg1', 'result1'),
					array('test2', NULL, 'result2'),
					array('test3', 'arg3', 'result3'),
				),
				array('result1', 'result2', 'result3')),
		);
	}

	/**
	 * @dataProvider dataAddChildrenObjects
	 * @covers Openbuildings\Cherry\Query\Query::addChildrenObjects
	 */
	public function testAddChildrenObjects($array, $argument, $calls)
	{
		$class = $this->getMock('stdClass', array('testMethod'));

		$expected = array();

		foreach ($calls as $index => $call)
		{
			$class
				->expects($this->at($index))
				->method('testMethod')
				->with($this->equalTo($call[0]), $this->equalTo($call[1]))
				->will($this->returnValue($call[2]));

			$expected []= $call[2];
		}

		$query = $this->getMock('Openbuildings\Cherry\Query\Query', array('sql'));


		$query->addChildrenObjects(Query::TABLE, $array, $argument, array($class, 'testMethod'));

		$this->assertEquals($query->children(Query::TABLE), $expected);
	}

	/**
	 * @covers Openbuildings\Cherry\Query\Query::db
	 */
	public function testDb()
	{
		$db = new DB(array());

		$query = $this->getMock('Openbuildings\Cherry\Query\Query', array('sql'), array(NULL, $db));

		$this->assertSame($db, $query->db());

		$query = $this->getMock('Openbuildings\Cherry\Query\Query', array('sql'));

		$this->assertSame(DB::instance(), $query->db());
	}

	/**
	 * @covers Openbuildings\Cherry\Query\Query::execute
	 */
	public function testExecute()
	{
		$query = $this->getMock('Openbuildings\Cherry\Query\Query', array('sql', 'parameters'));

		$query
			->expects($this->once())
			->method('sql')
			->will($this->returnValue('SELECT * FROM users WHERE name = ?'));

		$query
			->expects($this->once())
			->method('parameters')
			->will($this->returnValue(array('User 1')));

		$expected = array(
			array('id' => 1, 'name' => 'User 1'),
		);

		$this->assertEquals($expected, $query->execute()->fetchAll());
	}

	/**
	 * @covers Openbuildings\Cherry\Query\Query::humanize
	 */
	public function testHumanize()
	{
		$query = $this->getMock('Openbuildings\Cherry\Query\Query', array('sql', 'parameters'));

		$query
			->expects($this->once())
			->method('sql')
			->will($this->returnValue('SELECT * FROM users WHERE name = ?'));

		$query
			->expects($this->once())
			->method('parameters')
			->will($this->returnValue(array('User 1')));

		$this->assertEquals('SELECT * FROM users WHERE name = "User 1"', $query->humanize());
	}
}
