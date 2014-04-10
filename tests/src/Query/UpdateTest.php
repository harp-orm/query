<?php

namespace CL\Atlas\Test\Query;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\Query;
use CL\Atlas\SQL;

/**
 * @group query.update
 */
class UpdateTest extends AbstractTestCase
{
    /**
     * @covers CL\Atlas\Query\Update::table
     * @covers CL\Atlas\Query\Update::getTable
     */
    public function testTable()
    {
        $query = new Query\Update;

        $query
            ->table('table1')
            ->table('table2', 'alias2');

        $expected = array(
            new SQL\Aliased('table1'),
            new SQL\Aliased('table2', 'alias2'),
        );

        $this->assertEquals($expected, $query->getTable());
    }

    /**
     * @covers CL\Atlas\Query\Update::set
     * @covers CL\Atlas\Query\Update::getSet
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

        $this->assertEquals($expected, $query->getSet());
    }

    /**
     * @covers CL\Atlas\Query\Update::setMultiple
     */
    public function testSetMultiple()
    {
        $query = new Query\Update;

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

    /**
     * @covers CL\Atlas\Query\Update::getParameters
     */
    public function testGetParameters()
    {
        $query = new Query\Update;

        $query
            ->table('table1')
            ->set(array('name' => 10, 'value' => 5));

        $this->assertEquals(array(10, 5), $query->getParameters());
    }

}
