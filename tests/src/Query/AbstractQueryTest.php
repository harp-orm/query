<?php

namespace CL\Atlas\Test\Query;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\SQL;
use CL\Atlas\DB;

/**
 * @group query
 */
class AbstractQueryTest extends AbstractTestCase
{
    /**
     * @covers CL\Atlas\Query\AbstractQuery::type
     * @covers CL\Atlas\Query\AbstractQuery::getType
     */
    public function testType()
    {
        $query = $this->getMock('CL\Atlas\Query\AbstractQuery', array('sql', 'getParameters'));

        $query->type('IGNORE');

        $expected = new SQL\SQL('IGNORE');

        $this->assertEquals($expected, $query->getType());

        $query->type('IGNORE QUICK');

        $expected = new SQL\SQL('IGNORE QUICK');

        $this->assertEquals($expected, $query->getType());
    }

    /**
     * @covers CL\Atlas\Query\AbstractQuery::getDb
     * @covers CL\Atlas\Query\AbstractQuery::__construct
     */
    public function testDb()
    {
        $db = new DB(array());

        $query = $this->getMock('CL\Atlas\Query\AbstractQuery', array('sql', 'getParameters'), array($db));

        $this->assertSame($db, $query->getDb());

        $query = $this->getMock('CL\Atlas\Query\AbstractQuery', array('sql', 'getParameters'));

        $this->assertSame(DB::get(), $query->getDb());
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
