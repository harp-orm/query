<?php

namespace Harp\Query\Test;

use Harp\Query;
use Harp\Query\SQL;

/**
 * @group query.insert
 * @coversDefaultClass Harp\Query\Insert
 *
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class InsertTest extends AbstractTestCase
{
    /**
     * @covers ::into
     * @covers ::getTable
     * @covers ::setTable
     * @covers ::clearTable
     */
    public function testInto()
    {
        $query = new Query\Insert(self::getDb());

        $query->into('posts');

        $expected = new SQL\Aliased('posts');

        $this->assertEquals($expected, $query->getTable());

        $query->clearTable();

        $this->assertEmpty($query->getTable());

        $query->setTable($expected);

        $this->assertEquals($expected, $query->getTable());
    }

    /**
     * @covers ::columns
     * @covers ::getColumns
     * @covers ::setColumns
     * @covers ::clearColumns
     */
    public function testColumns()
    {
        $query = new Query\Insert(self::getDb());

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
     * @covers ::values
     * @covers ::getValues
     * @covers ::setValues
     * @covers ::clearValues
     */
    public function testValues()
    {
        $query = new Query\Insert(self::getDb());

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
     * @covers ::set
     * @covers ::getSet
     * @covers ::setSet
     * @covers ::clearSet
     */
    public function testSet()
    {
        $query = new Query\Insert(self::getDb());

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
     * @covers ::select
     * @covers ::getSelect
     * @covers ::setSelect
     * @covers ::clearSelect
     */
    public function testSelect()
    {
        $select = new Query\Select(self::getDb());
        $query = new Query\Insert(self::getDb());

        $query->select($select);

        $this->assertSame($select, $query->getSelect());

        $query->clearSelect();

        $this->assertEmpty($query->getSelect());

        $query->setSelect($select);

        $this->assertEquals($select, $query->getSelect());
    }

    /**
     * @covers ::getLastInsertId
     */
    public function testGetLastInsertId()
    {
        $db = $this->getMock(
            'Harp\Query\DB',
            array('getLastInsertId'),
            array('mysql:dbname=harp-orm/query;host=127.0.0.1', 'root')
        );

        $db
            ->expects($this->once())
            ->method('getLastInsertId')
            ->will($this->returnValue('123'));

        $query = new Query\Insert($db);

        $id = $query->getLastInsertId();

        $this->assertSame('123', $id);
    }

    /**
     * @covers ::sql
     */
    public function testSql()
    {
        $query = new Query\Insert(self::getDb());

        $query
            ->into('table1')
            ->set(array('name' => 10));

        $this->assertEquals('INSERT INTO `table1` SET `name` = ?', $query->sql());
    }

    /**
     * @covers ::getParameters
     */
    public function testGetParameters()
    {
        $query = new Query\Insert(self::getDb());

        $query
            ->into('table1')
            ->set(array('name' => 10, 'value' => 5));

        $this->assertEquals(array(10, 5), $query->getParameters());
    }

}
