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
     * @covers CL\Atlas\Query\AbstractWhere::setJoin
     * @covers CL\Atlas\Query\AbstractWhere::clearJoin
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

        $query->clearJoin();

        $this->assertEmpty($query->getJoin());

        $query->setJoin($expected);

        $this->assertEquals($expected, $query->getJoin());
    }

    /**
     * @covers CL\Atlas\Query\AbstractWhere::where
     * @covers CL\Atlas\Query\AbstractWhere::whereIn
     * @covers CL\Atlas\Query\AbstractWhere::whereRaw
     * @covers CL\Atlas\Query\AbstractWhere::getWhere
     * @covers CL\Atlas\Query\AbstractWhere::setWhere
     * @covers CL\Atlas\Query\AbstractWhere::clearWhere
     */
    public function testWhere()
    {
        $query = $this->getMock('CL\Atlas\Query\AbstractWhere', array('sql', 'getParameters'));

        $query
            ->where('test1', 2)
            ->whereIn('test2', array(2, 3))
            ->whereRaw('column = ? OR column = ?', array(10, 20))
            ->where('test3', 3);

        $expected = array(
            new SQL\ConditionIs('test1', 2),
            new SQL\ConditionIn('test2', array(2, 3)),
            new SQL\Condition('column = ? OR column = ?', array(10, 20)),
            new SQL\ConditionIs('test3', 3),
        );

        $this->assertEquals($expected, $query->getWhere());

        $query->clearWhere();

        $this->assertEmpty($query->getWhere());

        $query->setWhere($expected);

        $this->assertEquals($expected, $query->getWhere());
    }

    /**
     * @covers CL\Atlas\Query\AbstractWhere::where
     * @expectedException InvalidArgumentException
     */
    public function testWhereInInvalid()
    {
        $query = $this->getMock('CL\Atlas\Query\AbstractWhere', array('sql', 'getParameters'));

        $query->where('test1', array(2, 3));
    }
}
