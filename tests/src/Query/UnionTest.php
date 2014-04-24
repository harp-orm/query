<?php

namespace CL\Atlas\Test\Query;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\Query;

/**
 * @group query.union
 */
class UnionTest extends AbstractTestCase
{
    /**
     * @covers CL\Atlas\Query\Union::select
     * @covers CL\Atlas\Query\Union::getSelects
     */
    public function testSelect()
    {
        $query = new Query\Union;
        $select1 = new Query\Select;
        $select2 = new Query\Select;

        $query
            ->select($select1)
            ->select($select2);

        $expected = array(
            $select1,
            $select2,
        );

        $this->assertEquals($expected, $query->getSelects());
    }


    /**
     * @covers CL\Atlas\Query\Union::sql
     */
    public function testSql()
    {
        $query = new Query\Union;
        $select1 = new Query\Select;
        $select2 = new Query\Select;

        $select1
            ->from('table1')
            ->where(array('name' => 10));

        $select2
            ->from('table2')
            ->where(array('name' => 10));

        $query
            ->select($select1)
            ->select($select2);

        $this->assertEquals('(SELECT * FROM table1 WHERE (name = ?)) UNION (SELECT * FROM table2 WHERE (name = ?))', $query->sql());
    }

    /**
     * @covers CL\Atlas\Query\Union::getParameters
     */
    public function testGetParameters()
    {
        $query = new Query\Union;
        $select1 = new Query\Select;
        $select2 = new Query\Select;

        $select1
            ->from('table1')
            ->where(array('name' => 10));

        $select2
            ->from('table2')
            ->where(array('name' => array(1, 2)));

        $query
            ->select($select1)
            ->select($select2);

        $this->assertEquals(array(10, 1, 2), $query->getParameters());
    }
}
