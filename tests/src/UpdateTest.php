<?php

namespace Harp\Query\Test;

use Harp\Query;
use Harp\Query\SQL;

/**
 * @group query.update
 * @coversDefaultClass Harp\Query\Update
 *
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class UpdateTest extends AbstractTestCase
{
    /**
     * @covers ::table
     * @covers ::getTable
     * @covers ::setTable
     * @covers ::clearTable
     */
    public function testTable()
    {
        $query = new Query\Update(self::getDb());

        $query
            ->table('table1')
            ->table('table2', 'alias2');

        $expected = array(
            new SQL\Aliased('table1'),
            new SQL\Aliased('table2', 'alias2'),
        );

        $this->assertEquals($expected, $query->getTable());

        $query->clearTable();

        $this->assertEmpty($query->getTable());

        $query->setTable($expected);

        $this->assertEquals($expected, $query->getTable());
    }

    /**
     * @covers ::set
     * @covers ::getSet
     * @covers ::setSet
     * @covers ::clearSet
     */
    public function testSet()
    {
        $query = new Query\Update(self::getDb());

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
     * @covers ::setMultiple
     */
    public function testSetMultiple()
    {
        $query = new Query\Update(self::getDb());

        $query
            ->setMultiple(array(
                1 => array(
                    'name1' => 'name1',
                    'name2' => 10,
                    'name3' => 'test1',
                ),
                13 => array(
                    'name1' => 'name1',
                    'name3' => 'test2',
                ),
            ));

        $expected = array(
            new SQL\SetMultiple('name1', array(1 => 'name1', 13 => 'name1')),
            new SQL\SetMultiple('name2', array(1 => 10)),
            new SQL\SetMultiple('name3', array(1 => 'test1', 13 => 'test2')),
        );

        $this->assertEquals($expected, $query->getSet());
    }

    /**
     * @covers ::sql
     */
    public function testSql()
    {
        $query = new Query\Update(self::getDb());

        $query
            ->table('table1')
            ->set(array('name' => 10));

        $this->assertEquals('UPDATE `table1` SET `name` = ?', $query->sql());
    }

    /**
     * @covers ::getParameters
     */
    public function testGetParameters()
    {
        $query = new Query\Update(self::getDb());

        $query
            ->table('table1')
            ->set(array('name' => 10, 'value' => 5));

        $this->assertEquals(array(10, 5), $query->getParameters());
    }

}
