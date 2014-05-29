<?php

namespace Luna\Query\Test;

use Luna\Query;
use Luna\Query\SQL;

/**
 * @group query.delete
 * @coversDefaultClass Luna\Query\Delete
 */
class DeleteTest extends AbstractTestCase
{
    /**
     * @covers ::table
     * @covers ::getTable
     * @covers ::setTable
     * @covers ::clearTable
     */
    public function testTable()
    {
        $query = new Query\Delete();

        $query
            ->table('table1')
            ->table('table2');

        $expected = array(
            new SQL\Aliased('table1'),
            new SQL\Aliased('table2'),
        );

        $this->assertEquals($expected, $query->getTable());

        $query->clearTable();

        $this->assertEmpty($query->getTable());

        $query->setTable($expected);

        $this->assertEquals($expected, $query->getTable());
    }

    /**
     * @covers ::from
     * @covers ::getFrom
     * @covers ::setFrom
     * @covers ::clearFrom
     */
    public function testFrom()
    {
        $query = new Query\Delete();

        $query
            ->from('table1')
            ->from('table2', 'alias2');

        $expected = array(
            new SQL\Aliased('table1'),
            new SQL\Aliased('table2', 'alias2'),
        );

        $this->assertEquals($expected, $query->getFrom());

        $query->clearFrom();

        $this->assertEmpty($query->getFrom());

        $query->setFrom($expected);

        $this->assertEquals($expected, $query->getFrom());
    }

    /**
     * @covers ::sql
     */
    public function testSql()
    {
        $query = new Query\Delete();

        $query
            ->from('table1')
            ->limit(10);

        $this->assertEquals('DELETE FROM table1 LIMIT 10', $query->sql());
    }

    /**
     * @covers ::getParameters
     */
    public function testGetParameters()
    {
        $query = new Query\Delete();

        $query
            ->table('table1')
            ->where('name', 10)
            ->whereIn('value', array(2, 3));

        $this->assertEquals(array(10, 2, 3), $query->getParameters());
    }

}
