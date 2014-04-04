<?php namespace CL\Atlas\Test\Query;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\Query\AbstractQuery;
use CL\Atlas\SQL\SQL;
use CL\Atlas\DB;
use stdClass;
use CL\Atlas\Test\ParametrisedStub;

/**
 * @group query
 */
class QueryTest extends AbstractTestCase
{

    public function testConstants()
    {
        $constants = array(
            AbstractQuery::TYPE,
            AbstractQuery::TABLE,
            AbstractQuery::FROM,
            AbstractQuery::JOIN,
            AbstractQuery::COLUMNS,
            AbstractQuery::VALUES,
            AbstractQuery::SELECT,
            AbstractQuery::SET,
            AbstractQuery::WHERE,
            AbstractQuery::HAVING,
            AbstractQuery::GROUP_BY,
            AbstractQuery::ORDER_BY,
            AbstractQuery::LIMIT,
            AbstractQuery::OFFSET,
        );

        $this->assertEquals(count($constants), count(array_unique($constants)), 'Should not have repeating values');
    }

    /**
     * @covers CL\Atlas\Query\AbstractQuery::getChildren
     */
    public function testGetChildren()
    {
        $children = array(AbstractQuery::TYPE => 'ignore', AbstractQuery::LIMIT => 10);

        $query = $this->getMock('CL\Atlas\Query\AbstractQuery', array('sql'), array($children));

        $this->assertEquals($children, $query->getChildren());
    }

    /**
     * @covers CL\Atlas\Query\AbstractQuery::getChild
     */
    public function testGetChild()
    {
        $children = array(AbstractQuery::TYPE => 'ignore', AbstractQuery::LIMIT => 10);

        $query = $this->getMock('CL\Atlas\Query\AbstractQuery', array('sql'), array($children));

        $this->assertEquals('ignore', $query->getChild(AbstractQuery::TYPE));
        $this->assertEquals(10, $query->getChild(AbstractQuery::LIMIT));
        $this->assertEquals(null, $query->getChild('non existant'));
    }

    /**
     * @covers CL\Atlas\Query\AbstractQuery::getParameters
     */
    public function testGetParameters()
    {
        $object1 = $this->getMock('CL\Atlas\Test\ParametrisedStub', array('getParameters'));
        $object1
            ->expects($this->once())
            ->method('getParameters')
            ->will($this->returnValue(array('test1', 'test2', array('test3', 'test4', null))));

        $object2 = $this->getMock('CL\Atlas\Test\ParametrisedStub', array('getParameters'));
        $object2
            ->expects($this->once())
            ->method('getParameters')
            ->will($this->returnValue(array('test5')));

        $query = $this->getMock('CL\Atlas\Query\AbstractQuery', array('sql'), array(array('test', array($object1), $object2)));

        $this->assertEquals(array('test1', 'test2', 'test3', 'test4', null, 'test5'), $query->getParameters());

        $query = $this->getMock('CL\Atlas\Query\AbstractQuery', array('sql'));

        $this->assertEquals(array(), $query->getParameters());
    }

    /**
     * @covers CL\Atlas\Query\AbstractQuery::addChildren
     * @covers CL\Atlas\Query\AbstractQuery::__construct
     */
    public function testAddChildren()
    {
        $child1 = new stdClass;
        $child2 = new stdClass;
        $child3 = new stdClass;

        $query = $this->getMock('CL\Atlas\Query\AbstractQuery', array('sql'), array(array(AbstractQuery::TABLE => array($child1))));

        $query->addChildren(AbstractQuery::TABLE, array($child2));
        $query->addChildren(AbstractQuery::COLUMNS, array($child3));

        $expectedChildren = array(
            AbstractQuery::TABLE => array(
                $child1,
                $child2,
            ),
            AbstractQuery::COLUMNS => array(
                $child3,
            ),
        );

        $this->assertEquals($expectedChildren, $query->getChildren());
    }

    /**
     * @covers CL\Atlas\Query\AbstractQuery::db
     */
    public function testDb()
    {
        $db = new DB(array());

        $query = $this->getMock('CL\Atlas\Query\AbstractQuery', array('sql'), array(null, $db));

        $this->assertSame($db, $query->db());

        $query = $this->getMock('CL\Atlas\Query\AbstractQuery', array('sql'));

        $this->assertSame(DB::instance(), $query->db());
    }

    /**
     * @covers CL\Atlas\Query\AbstractQuery::execute
     */
    public function testExecute()
    {
        $query = $this->getMock('CL\Atlas\Query\AbstractQuery', array('sql', 'getParameters'));

        $query
            ->expects($this->once())
            ->method('sql')
            ->will($this->returnValue('SELECT * FROM users WHERE name = ?'));

        $query
            ->expects($this->once())
            ->method('getParameters')
            ->will($this->returnValue(array('User 1')));

        $expected = array(
            array('id' => 1, 'name' => 'User 1'),
        );

        $this->assertEquals($expected, $query->execute()->fetchAll());
    }

    /**
     * @covers CL\Atlas\Query\AbstractQuery::humanize
     */
    public function testHumanize()
    {
        $query = $this->getMock('CL\Atlas\Query\AbstractQuery', array('sql', 'getParameters'));

        $query
            ->expects($this->once())
            ->method('sql')
            ->will($this->returnValue('SELECT * FROM users WHERE name = ?'));

        $query
            ->expects($this->once())
            ->method('getParameters')
            ->will($this->returnValue(array('User 1')));

        $this->assertEquals('SELECT * FROM users WHERE name = "User 1"', $query->humanize());
    }
}
