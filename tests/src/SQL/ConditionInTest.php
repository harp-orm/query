<?php

namespace Harp\Query\Test\SQL;

use Harp\Query\Test\AbstractTestCase;
use Harp\Query\Query;
use Harp\Query\SQL;

/**
 * @group sql.condition
 * @coversDefaultClass Harp\Query\SQL\ConditionIn
 */
class ConditionInTest extends AbstractTestCase
{

    public function dataConstruct()
    {
        return array(
            array(
                'name',
                array(10),
                'IN ?',
                array(array(10))
            ),
            array(
                'name',
                array(10, 20),
                'IN ?',
                array(array(10, 20))
            ),
        );
    }

    /**
     * @dataProvider dataConstruct
     * @covers ::__construct
     */
    public function testConstruct($column, $value, $expected, $expectedParams)
    {
        $sqlCondition = new SQL\ConditionIn($column, $value);
        $this->assertEquals($column, $sqlCondition->getColumn());
        $this->assertEquals($expected, $sqlCondition->getContent());
        $this->assertEquals($expectedParams, $sqlCondition->getParameters());
    }

    /**
     * @expectedException InvalidArgumentException
     * @covers Harp\Query\SQL\ConditionIn::__construct
     */
    public function testConstructInvalid()
    {
        new SQL\ConditionIn('name', array());
    }
}
