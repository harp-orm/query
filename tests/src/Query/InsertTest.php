<?php

namespace CL\Atlas\Test\Query;

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

        $expected = new SQL\SQL('IGNORE');

        $this->assertEquals($expected, $query->getType());
    }

    /**
     * @covers CL\Atlas\Query\Insert::into
     */
    public function testInto()
    {
        $query = new Query\Insert;

        $query->into('posts');

        $expected = new SQL\Aliased('posts');

        $this->assertEquals($expected, $query->getTable());
    }

    /**
     * @covers CL\Atlas\Query\Insert::columns
     */
    public function testColumns()
    {
        $query = new Query\Insert;

        $query->columns(array('posts'));

        $expected = new SQL\Columns(array('posts'));

        $this->assertEquals($expected, $query->getColumns());

        $query->columns(array('col1', 'col2'));

        $expected = new SQL\Columns(array('col1', 'col2'));

        $this->assertEquals($expected, $query->getColumns());
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

        $this->assertEquals($expected, $query->getValues());
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

        $this->assertEquals($expected, $query->getSet());
    }

    /**
     * @covers CL\Atlas\Query\Insert::select
     */
    public function testSelect()
    {
        $select = new Query\Select;
        $query = new Query\Insert;

        $query->select($select);

        $this->assertSame($select, $query->getSelect());
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
