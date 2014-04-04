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
        $query = $this->getMock('CL\Atlas\Query\Delete', array('addChildren'));
        $query
            ->expects($this->at(0))
            ->method('addChildren')
            ->with($this->equalTo(Query\AbstractQuery::TABLE), $this->equalTo(array('table1')));

        $query
            ->expects($this->at(1))
            ->method('addChildren')
            ->with($this->equalTo(Query\AbstractQuery::TABLE), $this->equalTo(array('table1', 'table2')));

        $query->table('table1');
        $query->table(array('table1', 'table2'));
    }

    /**
     * @covers CL\Atlas\Query\Delete::from
     */
    public function testFrom()
    {
        $query = $this->getMock('CL\Atlas\Query\Delete', array('addChildrenObjects'));
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
     */
    public function testWhere()
    {
        $query = new Query\Delete;

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
     * @covers CL\Atlas\Query\Delete::order
     */
    public function testOrder()
    {
        $query = $this->getMock('CL\Atlas\Query\Delete', array('addChildrenObjects'));
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
