<?php namespace CL\Atlas\Test\Query;

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
     */
    public function testType()
    {
        $query = new Query\Update;

        $query->type('IGNORE');

        $this->assertEquals('IGNORE', $query->getChild(Query\AbstractQuery::TYPE));
    }

    /**
     * @covers CL\Atlas\Query\Update::table
     */
    public function testTable()
    {
        $query = $this->getMock('CL\Atlas\Query\Update', array('addChildrenObjects'));
        $query
            ->expects($this->once())
            ->method('addChildrenObjects')
            ->with(
                $this->equalTo(Query\AbstractQuery::TABLE),
                $this->equalTo(array('table1', 'table2' => 'alias2')),
                $this->equalTo('alias'),
                'CL\Atlas\SQL\Aliased::factory'
            );

        $query->table(array('table1', 'table2' => 'alias2'), 'alias');
    }

    /**
     * @covers CL\Atlas\Query\Update::join
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

        $this->assertEquals($expected, $query->getChild(Query\AbstractQuery::JOIN));
    }

    /**
     * @covers CL\Atlas\Query\Update::set
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

        $this->assertEquals($expected, $query->getChild(Query\AbstractQuery::SET));
    }

    /**
     * @covers CL\Atlas\Query\Update::where
     */
    public function testWhere()
    {
        $query = new Query\Update;

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
     * @covers CL\Atlas\Query\Update::order
     */
    public function testOrder()
    {
        $query = $this->getMock('CL\Atlas\Query\Update', array('addChildrenObjects'));
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
     * @covers CL\Atlas\Query\Update::limit
     */
    public function testLimit()
    {
        $query = new Query\Update;

        $query->limit(20);

        $this->assertEquals(20, $query->getChild(Query\AbstractQuery::LIMIT));
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
