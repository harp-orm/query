<?php

namespace Harp\Query\Test;

use Harp\Query;

/**
 * @group query.union
 * @coversDefaultClass Harp\Query\Union
 *
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class UnionTest extends AbstractTestCase
{
    /**
     * @covers ::select
     * @covers ::getSelects
     * @covers ::setSelects
     * @covers ::clearSelects
     */
    public function testSelect()
    {
        $query = new Query\Union();
        $select1 = new Query\Select();
        $select2 = new Query\Select();

        $query
            ->select($select1)
            ->select($select2);

        $expected = array(
            $select1,
            $select2,
        );

        $this->assertEquals($expected, $query->getSelects());

        $query->clearSelects();

        $this->assertEmpty($query->getSelects());

        $query->setSelects($expected);

        $this->assertEquals($expected, $query->getSelects());
    }


    /**
     * @covers ::sql
     */
    public function testSql()
    {
        $query = new Query\Union();
        $select1 = new Query\Select();
        $select2 = new Query\Select();

        $select1
            ->from('table1')
            ->where('name', 10);

        $select2
            ->from('table2')
            ->where('name', 10);

        $query
            ->select($select1)
            ->select($select2);

        $this->assertEquals('(SELECT * FROM table1 WHERE (name = ?)) UNION (SELECT * FROM table2 WHERE (name = ?))', $query->sql());
    }

    /**
     * @covers ::getParameters
     */
    public function testGetParameters()
    {
        $query = new Query\Union();
        $select1 = new Query\Select();
        $select2 = new Query\Select();

        $select1
            ->from('table1')
            ->where('name', 10);

        $select2
            ->from('table2')
            ->whereIn('name', array(1, 2));

        $query
            ->select($select1)
            ->select($select2);

        $this->assertEquals(array(10, 1, 2), $query->getParameters());
    }
}
