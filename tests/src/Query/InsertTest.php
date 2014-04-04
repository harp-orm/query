<?php namespace CL\Atlas\Test\Query;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\Query;
use CL\Atlas\SQL;

/**
 * @group query.insert
 */
class InsertTest extends AbstractTestCase
{

    /**
     * @covers CL\Atlas\Query\Insert::type
     */
    public function testType()
    {
        $query = new Query\Insert;

        $query->type('IGNORE');

        $this->assertEquals('IGNORE', $query->getChild(Query\AbstractQuery::TYPE));
    }

    /**
     * @covers CL\Atlas\Query\Insert::into
     */
    public function testInto()
    {
        $query = new Query\Insert;

        $query->into('posts');

        $this->assertEquals('posts', $query->getChild(Query\AbstractQuery::TABLE));
    }

    /**
     * @covers CL\Atlas\Query\Insert::columns
     */
    public function testColumns()
    {
        $query = new Query\Insert;

        $query->columns('posts');

        $this->assertEquals(array('posts'), $query->getChild(Query\AbstractQuery::COLUMNS));

        $query->columns(array('col1', 'col2'));

        $this->assertEquals(array('posts', 'col1', 'col2'), $query->getChild(Query\AbstractQuery::COLUMNS));
    }

    /**
     * @covers CL\Atlas\Query\Insert::values
     */
    public function testValues()
    {
        $query = new Query\Insert;

        $query
            ->values(array(10, 20))
            ->values(array(16, 26));

        $expected = array(
            new SQL\Values(array(10, 20)),
            new SQL\Values(array(16, 26)),
        );

        $this->assertEquals($expected, $query->getChild(Query\AbstractQuery::VALUES));
    }

    /**
     * @covers CL\Atlas\Query\Insert::set
     */
    public function testSet()
    {
        $query = new Query\Insert;

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
     * @covers CL\Atlas\Query\Insert::select
     */
    public function testSelect()
    {
        $select = new Query\Select;
        $query = new Query\Insert;

        $query->select($select);

        $this->assertSame($select, $query->getChild(Query\AbstractQuery::SELECT));
    }

    /**
     * @covers CL\Atlas\Query\Insert::sql
     */
    public function testSql()
    {
        $query = new Query\Insert;

        $query
            ->into('table1')
            ->set(array('name' => 10));

        $this->assertEquals('INSERT INTO table1 SET name = ?', $query->sql());
    }
}
