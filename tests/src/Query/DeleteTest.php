<?php

namespace CL\Atlas\Test\Query;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\Query;
use CL\Atlas\SQL;

/**
 * @group query.delete
 */
class DeleteTest extends AbstractTestCase
{

    /**
     * @covers CL\Atlas\Query\Delete::type
     * @covers CL\Atlas\Query\Delete::getType
     */
    public function testType()
    {
        $query = new Query\Delete;

        $query->type('IGNORE');

        $expected = new SQL\SQL('IGNORE');

        $this->assertEquals($expected, $query->getType());

        $query->type('IGNORE QUICK');

        $expected = new SQL\SQL('IGNORE QUICK');

        $this->assertEquals($expected, $query->getType());
    }

    /**
     * @covers CL\Atlas\Query\Delete::table
     * @covers CL\Atlas\Query\Delete::getTable
     */
    public function testTable()
    {
        $query = new Query\Delete;

        $query
            ->table('table1')
            ->table('table2');

        $expected = array(
            new SQL\Aliased('table1'),
            new SQL\Aliased('table2'),
        );

        $this->assertEquals($expected, $query->getTable());
    }

    /**
     * @covers CL\Atlas\Query\Delete::from
     * @covers CL\Atlas\Query\Delete::getFrom
     */
    public function testFrom()
    {
        $query = new Query\Delete;

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
     * @covers CL\Atlas\Query\Delete::join
     * @covers CL\Atlas\Query\Delete::getJoin
     */
    public function testJoin()
    {
        $query = new Query\Delete;

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
     * @covers CL\Atlas\Query\Delete::where
     * @covers CL\Atlas\Query\Delete::getWhere
     * @covers CL\Atlas\Query\Delete::whereRaw
     */
    public function testWhere()
    {
        $query = new Query\Delete;

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
     * @covers CL\Atlas\Query\Delete::order
     * @covers CL\Atlas\Query\Delete::getOrder
     */
    public function testOrder()
    {
        $query = new Query\Delete;

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
     * @covers CL\Atlas\Query\Delete::limit
     * @covers CL\Atlas\Query\Delete::getLimit
     */
    public function testLimit()
    {
        $query = new Query\Delete;

        $query->limit(20);

        $expected = new SQL\IntValue(20);

        $this->assertEquals($expected, $query->getLimit());
    }

    /**
     * @covers CL\Atlas\Query\Delete::sql
     */
    public function testSql()
    {
        $query = new Query\Delete;

        $query
            ->from('table1')
            ->limit(10);

        $this->assertEquals('DELETE FROM table1 LIMIT 10', $query->sql());
    }

    /**
     * @covers CL\Atlas\Query\Delete::getParameters
     */
    public function testGetParameters()
    {
        $query = new Query\Delete;

        $query
            ->table('table1')
            ->where(array('name' => 10, 'value' => array(2, 3)));

        $this->assertEquals(array(10, 2, 3), $query->getParameters());
    }

}
