<?php namespace CL\Atlas\Test\Query;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\Query\Query;
use CL\Atlas\Query\SelectQuery;
use CL\Atlas\SQL\ConditionSQL;
use CL\Atlas\SQL\JoinSQL;

/**
 * @group query.select
 */
class SelectQueryTest extends AbstractTestCase
{

    /**
     * @covers CL\Atlas\Query\SelectQuery::type
     */
    public function testType()
    {
        $query = new SelectQuery;

        $query->type('IGNORE');

        $this->assertEquals('IGNORE', $query->children(Query::TYPE));
    }

    /**
     * @covers CL\Atlas\Query\SelectQuery::columns
     */
    public function testColumns()
    {
        $query = $this->getMock('CL\Atlas\Query\SelectQuery', array('addChildrenObjects'));
        $query
            ->expects($this->once())
            ->method('addChildrenObjects')
            ->with(
                $this->equalTo(Query::COLUMNS),
                $this->equalTo(array('column1', 'column2' => 'alias2')),
                $this->equalTo('alias'),
                'CL\Atlas\SQL\AliasedSQL::factory'
            );

        $query->columns(array('column1', 'column2' => 'alias2'), 'alias');
    }

    /**
     * @covers CL\Atlas\Query\SelectQuery::from
     */
    public function testFrom()
    {
        $query = $this->getMock('CL\Atlas\Query\SelectQuery', array('addChildrenObjects'));
        $query
            ->expects($this->once())
            ->method('addChildrenObjects')
            ->with(
                $this->equalTo(Query::FROM),
                $this->equalTo(array('table1', 'table2' => 'alias2')),
                $this->equalTo('alias'),
                'CL\Atlas\SQL\AliasedSQL::factory'
            );

        $query->from(array('table1', 'table2' => 'alias2'), 'alias');
    }

    /**
     * @covers CL\Atlas\Query\SelectQuery::join
     */
    public function testJoin()
    {
        $query = new SelectQuery;

        $query
            ->join('table1', array('col' => 'col2'))
            ->join(array('table2', 'alias2'), 'USING (col1)', 'LEFT');

        $expected = array(
            new JoinSQL('table1', array('col' => 'col2')),
            new JoinSQL(array('table2', 'alias2'), 'USING (col1)', 'LEFT'),
        );

        $this->assertEquals($expected, $query->children(Query::JOIN));
    }

    /**
     * @covers CL\Atlas\Query\SelectQuery::where
     */
    public function testWhere()
    {
        $query = new SelectQuery;

        $query
            ->where(array('test' => 20))
            ->where('column = ? OR column = ?', 10, 20);

        $expected = array(
            new ConditionSQL(array('test' => 20)),
            new ConditionSQL('column = ? OR column = ?', array(10, 20)),
        );

        $this->assertEquals($expected, $query->children(Query::WHERE));
    }

    /**
     * @covers CL\Atlas\Query\SelectQuery::group
     */
    public function testGroup()
    {
        $query = $this->getMock('CL\Atlas\Query\SelectQuery', array('addChildrenObjects'));
        $query
            ->expects($this->once())
            ->method('addChildrenObjects')
            ->with(
                $this->equalTo(Query::GROUP_BY),
                $this->equalTo(array('column1', 'column2' => 'alias2')),
                $this->equalTo('direction'),
                'CL\Atlas\SQL\DirectionSQL::factory'
            );

        $query->group(array('column1', 'column2' => 'alias2'), 'direction');
    }

    /**
     * @covers CL\Atlas\Query\SelectQuery::having
     */
    public function testHaving()
    {
        $query = new SelectQuery;

        $query
            ->having(array('test' => 20))
            ->having('column = ? OR column = ?', 10, 20);

        $expected = array(
            new ConditionSQL(array('test' => 20)),
            new ConditionSQL('column = ? OR column = ?', array(10, 20)),
        );

        $this->assertEquals($expected, $query->children(Query::HAVING));
    }

    /**
     * @covers CL\Atlas\Query\SelectQuery::order
     */
    public function testOrder()
    {
        $query = $this->getMock('CL\Atlas\Query\SelectQuery', array('addChildrenObjects'));
        $query
            ->expects($this->once())
            ->method('addChildrenObjects')
            ->with(
                $this->equalTo(Query::ORDER_BY),
                $this->equalTo(array('column1', 'column2' => 'alias2')),
                $this->equalTo('direction'),
                'CL\Atlas\SQL\DirectionSQL::factory'
            );

        $query->order(array('column1', 'column2' => 'alias2'), 'direction');
    }

    /**
     * @covers CL\Atlas\Query\SelectQuery::limit
     */
    public function testLimit()
    {
        $query = new SelectQuery;

        $query->limit(20);

        $this->assertEquals(20, $query->children(Query::LIMIT));
    }

    /**
     * @covers CL\Atlas\Query\SelectQuery::offset
     */
    public function testOffset()
    {
        $query = new SelectQuery;

        $query->offset(20);

        $this->assertEquals(20, $query->children(Query::OFFSET));
    }

    /**
     * @covers CL\Atlas\Query\SelectQuery::sql
     */
    public function testSql()
    {
        $query = new SelectQuery;

        $query
            ->from('table1')
            ->where(array('name' => 10));

        $this->assertEquals('SELECT * FROM table1 WHERE (name = ?)', $query->sql());
    }
}
