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
     * @covers CL\Atlas\Query\Select::columns
     */
    public function testColumns()
    {
        $query = $this->getMock('CL\Atlas\Query\Select', array('addChildrenObjects'));
        $query
            ->expects($this->once())
            ->method('addChildrenObjects')
            ->with(
                $this->equalTo(Query\AbstractQuery::COLUMNS),
                $this->equalTo(array('column1', 'column2' => 'alias2')),
                $this->equalTo('alias'),
                'CL\Atlas\SQL\Aliased::factory'
            );

        $query->columns(array('column1', 'column2' => 'alias2'), 'alias');
    }

    /**
     * @covers CL\Atlas\Query\Select::from
     */
    public function testFrom()
    {
        $query = $this->getMock('CL\Atlas\Query\Select', array('addChildrenObjects'));
        $query
            ->expects($this->once())
            ->method('addChildrenObjects')
            ->with(
                $this->equalTo(Query\AbstractQuery::FROM),
                $this->equalTo(array('table1', 'table2' => 'alias2')),
                $this->equalTo('alias'),
                'CL\Atlas\SQL\Aliased::factory'
            );

        $query->from(array('table1', 'table2' => 'alias2'), 'alias');
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
     */
    public function testWhere()
    {
        $query = new Query\Select;

        $query
            ->where(array('test' => 20))
            ->where('column = ? OR column = ?', 10, 20);

        $expected = array(
            new SQL\Condition(array('test' => 20)),
            new SQL\Condition('column = ? OR column = ?', array(10, 20)),
        );

        $this->assertEquals($expected, $query->getChild(Query\AbstractQuery::WHERE));
    }

    /**
     * @covers CL\Atlas\Query\Select::group
     */
    public function testGroup()
    {
        $query = $this->getMock('CL\Atlas\Query\Select', array('addChildrenObjects'));
        $query
            ->expects($this->once())
            ->method('addChildrenObjects')
            ->with(
                $this->equalTo(Query\AbstractQuery::GROUP_BY),
                $this->equalTo(array('column1', 'column2' => 'alias2')),
                $this->equalTo('direction'),
                'CL\Atlas\SQL\Direction::factory'
            );

        $query->group(array('column1', 'column2' => 'alias2'), 'direction');
    }

    /**
     * @covers CL\Atlas\Query\Select::having
     */
    public function testHaving()
    {
        $query = new Query\Select;

        $query
            ->having(array('test' => 20))
            ->having('column = ? OR column = ?', 10, 20);

        $expected = array(
            new SQL\Condition(array('test' => 20)),
            new SQL\Condition('column = ? OR column = ?', array(10, 20)),
        );

        $this->assertEquals($expected, $query->getChild(Query\AbstractQuery::HAVING));
    }

    /**
     * @covers CL\Atlas\Query\Select::order
     */
    public function testOrder()
    {
        $query = $this->getMock('CL\Atlas\Query\Select', array('addChildrenObjects'));
        $query
            ->expects($this->once())
            ->method('addChildrenObjects')
            ->with(
                $this->equalTo(Query\AbstractQuery::ORDER_BY),
                $this->equalTo(array('column1', 'column2' => 'alias2')),
                $this->equalTo('direction'),
                'CL\Atlas\SQL\Direction::factory'
            );

        $query->order(array('column1', 'column2' => 'alias2'), 'direction');
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
