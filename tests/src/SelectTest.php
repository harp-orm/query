<?php

namespace Harp\Query\Test;

use Harp\Query;
use Harp\Query\SQL;

/**
 * @group query.select
 * @coversDefaultClass Harp\Query\Select
 *
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class SelectTest extends AbstractTestCase
{
    /**
     * @covers ::column
     * @covers ::prependColumn
     * @covers ::getColumns
     * @covers ::setColumns
     * @covers ::clearColumns
     */
    public function testColumn()
    {
        $query = new Query\Select(self::getDb());

        $query
            ->column('column1')
            ->column('column2', 'alias2')
            ->prependColumn('column0', 'alias0');

        $expected = array(
            new SQL\Aliased('column0', 'alias0'),
            new SQL\Aliased('column1'),
            new SQL\Aliased('column2', 'alias2'),
        );

        $this->assertEquals($expected, $query->getColumns());

        $query->clearColumns();

        $this->assertEmpty($query->getColumns());

        $query->setColumns($expected);

        $this->assertEquals($expected, $query->getColumns());
    }

    /**
     * @covers ::from
     * @covers ::getFrom
     * @covers ::setFrom
     * @covers ::clearFrom
     */
    public function testFrom()
    {
        $query = new Query\Select(self::getDb());

        $query
            ->from('table1')
            ->from('table2', 'alias2');

        $expected = array(
            new SQL\Aliased('table1'),
            new SQL\Aliased('table2', 'alias2'),
        );

        $this->assertEquals($expected, $query->getFrom());

        $query->clearFrom();

        $this->assertEmpty($query->getFrom());

        $query->setFrom($expected);

        $this->assertEquals($expected, $query->getFrom());
    }

    /**
     * @covers ::group
     * @covers ::getGroup
     * @covers ::setGroup
     * @covers ::clearGroup
     */
    public function testGroup()
    {
        $query = new Query\Select(self::getDb());

        $query
            ->group('col1')
            ->group('col2', 'dir2');

        $expected = array(
            new SQL\Direction('col1'),
            new SQL\Direction('col2', 'dir2'),
        );

        $this->assertEquals($expected, $query->getGroup());

        $query->clearGroup();

        $this->assertEmpty($query->getGroup());

        $query->setGroup($expected);

        $this->assertEquals($expected, $query->getGroup());
    }

    /**
     * @covers ::having
     * @covers ::havingIn
     * @covers ::havingLike
     * @covers ::havingNot
     * @covers ::havingRaw
     * @covers ::getHaving
     * @covers ::setHaving
     * @covers ::clearHaving
     */
    public function testHaving()
    {

        $query = new Query\Select(self::getDb());

        $query
            ->having('test1', 2)
            ->havingIn('test2', array(2, 3))
            ->havingNot('test4', '123')
            ->havingLike('test5', '123%')
            ->havingRaw('column = ? OR column = ?', array(10, 20))
            ->having('test3', 3);

        $expected = array(
            new SQL\ConditionIs('test1', 2),
            new SQL\ConditionIn('test2', array(2, 3)),
            new SQL\ConditionNot('test4', '123'),
            new SQL\ConditionLike('test5', '123%'),
            new SQL\Condition(null, 'column = ? OR column = ?', array(10, 20)),
            new SQL\ConditionIs('test3', 3),
        );

        $this->assertEquals($expected, $query->getHaving());

        $query->clearHaving();

        $this->assertEmpty($query->getHaving());

        $query->setHaving($expected);

        $this->assertEquals($expected, $query->getHaving());
    }

    /**
     * @covers ::having
     * @expectedException InvalidArgumentException
     */
    public function testWhereInInvalid()
    {
        $query = $this->getMock('Harp\Query\Select', array('sql', 'getParameters'), array(self::getDb()));

        $query->having('test1', array(2, 3));
    }

    /**
     * @covers ::offset
     * @covers ::getOffset
     * @covers ::setOffset
     * @covers ::clearOffset
     */
    public function testOffset()
    {
        $query = new Query\Select(self::getDb());

        $query->offset(20);

        $expected = new SQL\IntValue(20);

        $this->assertEquals($expected, $query->getOffset());

        $query->clearOffset();

        $this->assertEmpty($query->getOffset());

        $query->setOffset($expected);

        $this->assertEquals($expected, $query->getOffset());
    }

    /**
     * @covers ::sql
     */
    public function testSql()
    {
        $query = new Query\Select(self::getDb());

        $query
            ->from('table1')
            ->where('name', 10);

        $this->assertEquals('SELECT * FROM `table1` WHERE (`name` = ?)', $query->sql());
    }

    /**
     * @covers ::getParameters
     */
    public function testGetParameters()
    {
        $query = new Query\Select(self::getDb());

        $query
            ->from('table1')
            ->where('name', 10)
            ->whereIn('value', array(2, 3));

        $this->assertEquals(array(10, 2, 3), $query->getParameters());
    }
}
