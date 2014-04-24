<?php

namespace CL\Atlas\Test\Query;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\SQL;

/**
 * @group query
 */
class AbstractWhereTest extends AbstractTestCase
{
    /**
     * @covers CL\Atlas\Query\AbstractWhere::join
     * @covers CL\Atlas\Query\AbstractWhere::joinAliased
     * @covers CL\Atlas\Query\AbstractWhere::getJoin
     */
    public function testJoin()
    {
        $query = $this->getMock('CL\Atlas\Query\AbstractWhere', array('sql', 'getParameters'));

        $query
            ->join('table1', array('col' => 'col2'))
            ->joinAliased('table2', 'alias2', 'USING (col1)', 'LEFT');

        $expected = array(
            new SQL\Join(new SQL\Aliased('table1'), array('col' => 'col2')),
            new SQL\Join(new SQL\Aliased('table2', 'alias2'), 'USING (col1)', 'LEFT'),
        );

        $this->assertEquals($expected, $query->getJoin());
    }

    /**
     * @covers CL\Atlas\Query\AbstractWhere::where
     * @covers CL\Atlas\Query\AbstractWhere::getWhere
     * @covers CL\Atlas\Query\AbstractWhere::whereRaw
     */
    public function testWhere()
    {
        $query = $this->getMock('CL\Atlas\Query\AbstractWhere', array('sql', 'getParameters'));

        $query
            ->where(array('test1' => 1, 'test2' => 2))
            ->whereRaw('column = ? OR column = ?', array(10, 20))
            ->where(array('test3' => 3));

        $expected = array(
            new SQL\ConditionArray(array('test1' => 1, 'test2' => 2)),
            new SQL\Condition('column = ? OR column = ?', array(10, 20)),
            new SQL\ConditionArray(array('test3' => 3)),
        );

        $this->assertEquals($expected, $query->getWhere());
    }
}
