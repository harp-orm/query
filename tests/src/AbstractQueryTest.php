<?php

namespace Harp\Query\Test;

use Harp\Query\SQL;
use Harp\Query\DB;

/**
 * @group query
 * @coversDefaultClass Harp\Query\AbstractQuery
 */
class AbstractQueryTest extends AbstractTestCase
{
    /**
     * @covers ::type
     * @covers ::getType
     * @covers ::setType
     * @covers ::clearType
     */
    public function testType()
    {
        $query = $this->getMock('Harp\Query\AbstractQuery', array('sql', 'getParameters'));

        $query->type('IGNORE');

        $expected = new SQL\SQL('IGNORE');

        $this->assertEquals($expected, $query->getType());

        $query->type('IGNORE QUICK');

        $expected = new SQL\SQL('IGNORE QUICK');

        $this->assertEquals($expected, $query->getType());

        $query->setType($expected);

        $this->assertEquals($expected, $query->getType());

        $query->clearType();

        $this->assertNull($query->getType());
    }

    /**
     * @covers ::getDb
     * @covers ::__construct
     */
    public function testDb()
    {
        $db = DB::get();

        $query = $this->getMock('Harp\Query\AbstractQuery', array('sql', 'getParameters'), array($db));

        $this->assertSame($db, $query->getDb());

        $query = $this->getMock('Harp\Query\AbstractQuery', array('sql', 'getParameters'));

        $this->assertSame(DB::get(), $query->getDb());
    }

    /**
     * @covers ::execute
     */
    public function testExecute()
    {
        $query = $this->getMock('Harp\Query\AbstractQuery', array('sql', 'getParameters'));

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
     * @covers ::humanize
     */
    public function testHumanize()
    {
        $query = $this->getMock('Harp\Query\AbstractQuery', array('sql', 'getParameters'));

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
