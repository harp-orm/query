<?php

namespace CL\Atlas\Test\SQL;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\Query\Query;
use CL\Atlas\SQL;

/**
 * @group sql.condition
 */
class ConditionInTest extends AbstractTestCase
{

    public function dataConstruct()
    {
        return array(
            array(
                'name',
                array(10),
                'name IN ?',
                array(array(10))
            ),
            array(
                'name',
                array(10, 20),
                'name IN ?',
                array(array(10, 20))
            ),
        );
    }

    /**
     * @dataProvider dataConstruct
     * @covers CL\Atlas\SQL\ConditionIn::__construct
     */
    public function testConstruct($column, $value, $expected, $expectedParams)
    {
        $sqlCondition = new SQL\ConditionIn($column, $value);
        $this->assertEquals($expected, $sqlCondition->getContent());
        $this->assertEquals($expectedParams, $sqlCondition->getParameters());
    }

    /**
     * @expectedException InvalidArgumentException
     * @covers CL\Atlas\SQL\ConditionIn::__construct
     */
    public function testConstructInvalid()
    {
        new SQL\ConditionIn('name', array());
    }
}
