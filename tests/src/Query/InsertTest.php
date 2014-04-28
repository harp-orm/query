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
     * @covers CL\Atlas\Query\Insert::into
     * @covers CL\Atlas\Query\Insert::getTable
     * @covers CL\Atlas\Query\Insert::setTable
     * @covers CL\Atlas\Query\Insert::clearTable
     */
    public function testInto()
    {
        $query = new Query\Insert;

        $query->into('posts');

        $expected = new SQL\Aliased('posts');

        $this->assertEquals($expected, $query->getTable());

        $query->clearTable();

        $this->assertEmpty($query->getTable());

        $query->setTable($expected);

        $this->assertEquals($expected, $query->getTable());
    }

    /**
     * @covers CL\Atlas\Query\Insert::columns
     * @covers CL\Atlas\Query\Insert::getColumns
     * @covers CL\Atlas\Query\Insert::setColumns
     * @covers CL\Atlas\Query\Insert::clearColumns
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

        $query->clearColumns();

        $this->assertEmpty($query->getColumns());

        $query->setColumns($expected);

        $this->assertEquals($expected, $query->getColumns());
    }

    /**
     * @covers CL\Atlas\Query\Insert::values
     * @covers CL\Atlas\Query\Insert::getValues
     * @covers CL\Atlas\Query\Insert::setValues
     * @covers CL\Atlas\Query\Insert::clearValues
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

        $query->clearValues();

        $this->assertEmpty($query->getValues());

        $query->setValues($expected);

        $this->assertEquals($expected, $query->getValues());
    }

    /**
     * @covers CL\Atlas\Query\Insert::set
     * @covers CL\Atlas\Query\Insert::getSet
     * @covers CL\Atlas\Query\Insert::setSet
     * @covers CL\Atlas\Query\Insert::clearSet
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

        $query->clearSet();

        $this->assertEmpty($query->getSet());

        $query->setSet($expected);

        $this->assertEquals($expected, $query->getSet());
    }

    /**
     * @covers CL\Atlas\Query\Insert::select
     * @covers CL\Atlas\Query\Insert::getSelect
     * @covers CL\Atlas\Query\Insert::setSelect
     * @covers CL\Atlas\Query\Insert::clearSelect
     */
    public function testSelect()
    {
        $select = new Query\Select;
        $query = new Query\Insert;

        $query->select($select);

        $this->assertSame($select, $query->getSelect());

        $query->clearSelect();

        $this->assertEmpty($query->getSelect());

        $query->setSelect($select);

        $this->assertEquals($select, $query->getSelect());
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

    /**
     * @covers CL\Atlas\Query\Insert::getParameters
     */
    public function testGetParameters()
    {
        $query = new Query\Insert;

        $query
            ->into('table1')
            ->set(array('name' => 10, 'value' => 5));

        $this->assertEquals(array(10, 5), $query->getParameters());
    }

}
