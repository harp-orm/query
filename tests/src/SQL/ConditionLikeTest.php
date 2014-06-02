<?php

namespace Harp\Query\Test\SQL;

use Harp\Query\Test\AbstractTestCase;
use Harp\Query\Query;
use Harp\Query\SQL;

/**
 * @group sql.condition
 * @coversDefaultClass Harp\Query\SQL\ConditionLike
 */
class ConditionLikeTest extends AbstractTestCase
{

    public function dataConstruct()
    {
        return array(
            array(
                'name',
                'test',
                'name LIKE ?',
                array('test')
            ),
            array(
                'name',
                '%test%',
                'name LIKE ?',
                array('%test%')
            ),
        );
    }

    /**
     * @dataProvider dataConstruct
     * @covers ::__construct
     */
    public function testConstruct($column, $value, $expected, $expectedParams)
    {
        $sqlCondition = new SQL\ConditionLike($column, $value);
        $this->assertEquals($expected, $sqlCondition->getContent());
        $this->assertEquals($expectedParams, $sqlCondition->getParameters());
    }
}
