<?php

namespace CL\Atlas\Test\Query;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\Query;
use CL\Atlas\SQL;

/**
 * @group query.update
 */
class UpdateTest extends AbstractTestCase
{
    /**
     * @covers CL\Atlas\Query\Update::type
     * @covers CL\Atlas\Query\Update::getType
     */
    public function testType()
    {
        $query = new Query\Update;

        $query->type('IGNORE');

        $expected = new SQL\SQL('IGNORE');

        $this->assertEquals($expected, $query->getType());
    }

    /**
     * @covers CL\Atlas\Query\Update::table
     * @covers CL\Atlas\Query\Update::getTable
     */
    public function testTable()
    {
        $query = new Query\Update;

        $query
            ->table('table1')
            ->table('table2', 'alias2');

        $expected = array(
            new SQL\Aliased('table1'),
            new SQL\Aliased('table2', 'alias2'),
        );

        $this->assertEquals($expected, $query->getTable());
    }

    /**
     * @covers CL\Atlas\Query\Update::join
     * @covers CL\Atlas\Query\Update::getJoin
     */
    public function testJoin()
    {
        $query = new Query\Update;

        $query
            ->join('table1', array('col' => 'col2'))
            ->join(array('table2', 'alias2'), 'USING (col1)', 'LEFT');

        $expected = array(
            new SQL\Join('table1', array('col' => 'col2')),
            new SQL\Join(array('table2', 'alias2'), 'USING (col1)', 'LEFT'),
        );

        $this->assertEquals($expected, $query->getJoin());
    }

    /**
     * @covers CL\Atlas\Query\Update::set
     * @covers CL\Atlas\Query\Update::getSet
     */
    public function testSet()
    {
        $query = new Query\Update;

        $query
            ->set(array('test' => 20, 'value' => 10))
            ->set(array('name' => 'test'));

        $expected = array(
            new SQL\Set('test', 20),
            new SQL\Set('value', 10),
            new SQL\Set('name', 'test'),
        );

        $this->assertEquals($expected, $query->getSet());
    }

    /**
     * @covers CL\Atlas\Query\Update::where
     * @covers CL\Atlas\Query\Update::getWhere
     * @covers CL\Atlas\Query\Update::whereRaw
     */
    public function testWhere()
    {
        $query = new Query\Update;

        $query
            ->where(array('test1' => 1, 'test2' => 2))
            ->whereRaw('column = ? OR column = ?', 10, 20)
            ->where(array('test3' => 3));

        $expected = array(
            new SQL\ConditionArray(array('test1' => 1, 'test2' => 2)),
            new SQL\Condition('column = ? OR column = ?', array(10, 20)),
            new SQL\ConditionArray(array('test3' => 3)),
        );

        $this->assertEquals($expected, $query->getWhere());
    }

    /**
     * @covers CL\Atlas\Query\Update::order
     * @covers CL\Atlas\Query\Update::getOrder
     */
    public function testOrder()
    {
        $query = new Query\Update;

        $query
            ->order('col1')
            ->order('col2', 'dir2');

        $expected = array(
            new SQL\Direction('col1'),
            new SQL\Direction('col2', 'dir2'),
        );

        $this->assertEquals($expected, $query->getOrder());
    }

    /**
     * @covers CL\Atlas\Query\Update::limit
     * @covers CL\Atlas\Query\Update::getLimit
     */
    public function testLimit()
    {
        $query = new Query\Update;

        $query->limit(20);

        $expected = new SQL\IntValue(20);

        $this->assertEquals($expected, $query->getLimit());
    }

    /**
     * @covers CL\Atlas\Query\Update::sql
     */
    public function testSql()
    {
        $query = new Query\Update;

        $query
            ->table('table1')
            ->set(array('name' => 10));

        $this->assertEquals('UPDATE table1 SET name = ?', $query->sql());
    }
}
