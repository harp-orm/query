<?php

namespace Harp\Query\Test\SQL;

use Harp\Query\Test\AbstractTestCase;
use Harp\Query\Query;
use Harp\Query\SQL;

/**
 * @group sql.condition
 * @coversDefaultClass Harp\Query\SQL\ConditionIs
 */
class ConditionIsTest extends AbstractTestCase
{

    public function dataConstruct()
    {
        return array(
            array(
                'name',
                10,
                '= ?',
                array(10)
            ),
            array(
                'name',
                null,
                'IS NULL',
                null,
            ),
        );
    }

    /**
     * @dataProvider dataConstruct
     * @covers ::__construct
     */
    public function testConstruct($column, $value, $expected, $expectedParams)
    {
        $sqlCondition = new SQL\ConditionIs($column, $value);
        $this->assertEquals($column, $sqlCondition->getColumn());
        $this->assertEquals($expected, $sqlCondition->getContent());
        $this->assertEquals($expectedParams, $sqlCondition->getParameters());
    }

    /**
     * @expectedException InvalidArgumentException
     * @covers ::__construct
     */
    public function testConstructInvalid()
    {
        new SQL\ConditionIs('name', array(10));
    }
}
