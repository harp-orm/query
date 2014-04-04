<?php namespace CL\Atlas\Test\Query;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\Query;
use CL\Atlas\SQL;

/**
 * @group query.select
 */
class SelectTest extends AbstractTestCase
{

    /**
     * @covers CL\Atlas\Query\Select::type
     */
    public function testType()
    {
        $query = new Query\Select;

        $query->type('IGNORE');

        $this->assertEquals('IGNORE', $query->getChild(Query\AbstractQuery::TYPE));
    }

    /**
     * @covers CL\Atlas\Query\Select::column
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

        $this->assertEquals($expected, $query->getChild(Query\AbstractQuery::COLUMNS));
    }

    /**
     * @covers CL\Atlas\Query\Select::from
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

        $this->assertEquals($expected, $query->getChild(Query\AbstractQuery::FROM));
    }
    /**
     * @covers CL\Atlas\Query\Select::join
     */
    public function testJoin()
    {
        $query = new Query\Select;

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
     * @covers CL\Atlas\Query\Select::where
     * @covers CL\Atlas\Query\Select::whereRaw
     */
    public function testWhere()
    {
        $query = new Query\Select;

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
     * @covers CL\Atlas\Query\Select::group
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

        $this->assertEquals($expected, $query->getChild(Query\AbstractQuery::GROUP_BY));
    }

    /**
     * @covers CL\Atlas\Query\Select::having
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

        $this->assertEquals($expected, $query->getChild(Query\AbstractQuery::HAVING));
    }
    /**
     * @covers CL\Atlas\Query\Select::order
     */
    public function testOrder()
    {
        $query = new Query\Select;

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
     * @covers CL\Atlas\Query\Select::limit
     */
    public function testLimit()
    {
        $query = new Query\Select;

        $query->limit(20);

        $this->assertEquals(20, $query->getChild(Query\AbstractQuery::LIMIT));
    }

    /**
     * @covers CL\Atlas\Query\Select::offset
     */
    public function testOffset()
    {
        $query = new Query\Select;

        $query->offset(20);

        $this->assertEquals(20, $query->getChild(Query\AbstractQuery::OFFSET));
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
}
