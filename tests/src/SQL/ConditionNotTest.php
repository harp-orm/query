<?php

namespace CL\Atlas\Test\SQL;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\Query\Query;
use CL\Atlas\SQL;

/**
 * @group sql.condition
 */
class ConditionNotTest extends AbstractTestCase
{

    public function dataConstruct()
    {
        return array(
            array(
                'name',
                10,
                'name != ?',
                array(10)
            ),
            array(
                'name',
                null,
                'name IS NOT NULL',
                null,
            ),
        );
    }

    /**
     * @dataProvider dataConstruct
     * @covers CL\Atlas\SQL\ConditionNot::__construct
     */
    public function testConstruct($column, $value, $expected, $expectedParams)
    {
        $sqlCondition = new SQL\ConditionNot($column, $value);
        $this->assertEquals($expected, $sqlCondition->getContent());
        $this->assertEquals($expectedParams, $sqlCondition->getParameters());
    }

    /**
     * @expectedException InvalidArgumentException
     * @covers CL\Atlas\SQL\ConditionNot::__construct
     */
    public function testConstructInvalid()
    {
        new SQL\ConditionNot('name', array(10));
    }
}
