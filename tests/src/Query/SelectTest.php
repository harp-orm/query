<?php

namespace CL\Atlas\Test\Query;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\Query;
use CL\Atlas\SQL;

/**
 * @group query.select
 */
class SelectTest extends AbstractTestCase
{
    /**
     * @covers CL\Atlas\Query\Select::column
     * @covers CL\Atlas\Query\Select::prependColumn
     * @covers CL\Atlas\Query\Select::getColumns
     * @covers CL\Atlas\Query\Select::setColumns
     * @covers CL\Atlas\Query\Select::clearColumns
     */
    public function testColumn()
    {
        $query = new Query\Select;

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
     * @covers CL\Atlas\Query\Select::from
     * @covers CL\Atlas\Query\Select::getFrom
     * @covers CL\Atlas\Query\Select::setFrom
     * @covers CL\Atlas\Query\Select::clearFrom
     */
    public function testFrom()
    {
        $query = new Query\Select;

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
     * @covers CL\Atlas\Query\Select::group
     * @covers CL\Atlas\Query\Select::getGroup
     * @covers CL\Atlas\Query\Select::setGroup
     * @covers CL\Atlas\Query\Select::clearGroup
     */
    public function testGroup()
    {
        $query = new Query\Select;

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
     * @covers CL\Atlas\Query\Select::having
     * @covers CL\Atlas\Query\Select::getHaving
     * @covers CL\Atlas\Query\Select::setHaving
     * @covers CL\Atlas\Query\Select::havingRaw
     * @covers CL\Atlas\Query\Select::clearHaving
     */
    public function testHaving()
    {
        $query = new Query\Select;

        $query
            ->having(array('test1' => 1, 'test2' => 2))
            ->havingRaw('column = ? OR column = ?', array(10, 20))
            ->having(array('test3' => 3));

        $expected = array(
            new SQL\ConditionArray(array('test1' => 1, 'test2' => 2)),
            new SQL\Condition('column = ? OR column = ?', array(10, 20)),
            new SQL\ConditionArray(array('test3' => 3)),
        );

        $this->assertEquals($expected, $query->getHaving());

        $query->clearHaving();

        $this->assertEmpty($query->getHaving());

        $query->setHaving($expected);

        $this->assertEquals($expected, $query->getHaving());
    }

    /**
     * @covers CL\Atlas\Query\Select::offset
     * @covers CL\Atlas\Query\Select::getOffset
     * @covers CL\Atlas\Query\Select::setOffset
     * @covers CL\Atlas\Query\Select::clearOffset
     */
    public function testOffset()
    {
        $query = new Query\Select;

        $query->offset(20);

        $expected = new SQL\IntValue(20);

        $this->assertEquals($expected, $query->getOffset());

        $query->clearOffset();

        $this->assertEmpty($query->getOffset());

        $query->setOffset($expected);

        $this->assertEquals($expected, $query->getOffset());
    }

    /**
     * @covers CL\Atlas\Query\Select::sql
     */
    public function testSql()
    {
        $query = new Query\Select;

        $query
            ->from('table1')
            ->where(array('name' => 10));

        $this->assertEquals('SELECT * FROM table1 WHERE (name = ?)', $query->sql());
    }

    /**
     * @covers CL\Atlas\Query\Select::getParameters
     */
    public function testGetParameters()
    {
        $query = new Query\Select;

        $query
            ->from('table1')
            ->where(array('name' => 10, 'value' => array(2, 3)));

        $this->assertEquals(array(10, 2, 3), $query->getParameters());
    }
}
