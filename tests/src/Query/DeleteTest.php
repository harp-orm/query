<?php namespace CL\Atlas\Test\Query;

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
     */
    public function testType()
    {
        $query = new Query\Delete;

        $query->type('IGNORE');

        $this->assertEquals('IGNORE', $query->getChild(Query\AbstractQuery::TYPE));

        $query->type('IGNORE QUICK');

        $this->assertEquals('IGNORE QUICK', $query->getChild(Query\AbstractQuery::TYPE));
    }

    /**
     * @covers CL\Atlas\Query\Delete::table
     */
    public function testTable()
    {
        $query = new Query\Delete;

        $query
            ->table('table1')
            ->table('table2');

        $expected = array(
            'table1',
            'table2',
        );

        $this->assertEquals($expected, $query->getChild(Query\AbstractQuery::TABLE));
    }

    /**
     * @covers CL\Atlas\Query\Delete::from
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

        $this->assertEquals($expected, $query->getChild(Query\AbstractQuery::FROM));
    }

    /**
     * @covers CL\Atlas\Query\Delete::join
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

        $this->assertEquals($expected, $query->getChild(Query\AbstractQuery::JOIN));
    }

    /**
     * @covers CL\Atlas\Query\Delete::where
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

        $this->assertEquals($expected, $query->getChild(Query\AbstractQuery::WHERE));
    }

    /**
     * @covers CL\Atlas\Query\Delete::order
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

        $this->assertEquals($expected, $query->getChild(Query\AbstractQuery::ORDER_BY));
    }


    /**
     * @covers CL\Atlas\Query\Delete::limit
     */
    public function testLimit()
    {
        $query = new Query\Delete;

        $query->limit(20);

        $this->assertEquals(20, $query->getChild(Query\AbstractQuery::LIMIT));
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
}
