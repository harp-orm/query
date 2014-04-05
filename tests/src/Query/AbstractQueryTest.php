<?php

namespace CL\Atlas\Test\Query;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\DB;

/**
 * @group query
 */
class QueryTest extends AbstractTestCase
{
    /**
     * @covers CL\Atlas\Query\AbstractQuery::db
     * @covers CL\Atlas\Query\AbstractQuery::__construct
     */
    public function testDb()
    {
        $db = new DB(array());

        $query = $this->getMock('CL\Atlas\Query\AbstractQuery', array('sql', 'getParameters'), array($db));

        $this->assertSame($db, $query->db());

        $query = $this->getMock('CL\Atlas\Query\AbstractQuery', array('sql', 'getParameters'));

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
