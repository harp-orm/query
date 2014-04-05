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
     * @covers CL\Atlas\Query\Select::getColumns
     */
    public function testColumn()
    {
        $query = new Query\Select;

        $query
            ->column('column1')
            ->column('column2', 'alias2');

        $expected = array(
            new SQL\Aliased('column1'),
            new SQL\Aliased('column2', 'alias2'),
        );

        $this->assertEquals($expected, $query->getColumns());
    }

    /**
     * @covers CL\Atlas\Query\Select::from
     * @covers CL\Atlas\Query\Select::getFrom
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
    }

    /**
     * @covers CL\Atlas\Query\Select::group
     * @covers CL\Atlas\Query\Select::getGroup
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
    }

    /**
     * @covers CL\Atlas\Query\Select::having
     * @covers CL\Atlas\Query\Select::getHaving
     * @covers CL\Atlas\Query\Select::havingRaw
     */
    public function testHaving()
    {
        $query = new Query\Select;

        $query
            ->having(array('test1' => 1, 'test2' => 2))
            ->havingRaw('column = ? OR column = ?', 10, 20)
            ->having(array('test3' => 3));

        $expected = array(
            new SQL\ConditionArray(array('test1' => 1, 'test2' => 2)),
            new SQL\Condition('column = ? OR column = ?', array(10, 20)),
            new SQL\ConditionArray(array('test3' => 3)),
        );

        $this->assertEquals($expected, $query->getHaving());
    }

    /**
     * @covers CL\Atlas\Query\Select::offset
     * @covers CL\Atlas\Query\Select::getOffset
     */
    public function testOffset()
    {
        $query = new Query\Select;

        $query->offset(20);

        $expected = new SQL\IntValue(20);

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
