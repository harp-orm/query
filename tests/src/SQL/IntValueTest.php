<?php

namespace Luna\Query\Test\SQL;

use Luna\Query\Test\AbstractTestCase;
use Luna\Query\SQL;

/**
 * @group sql.int_value
 * @coversDefaultClass Luna\Query\SQL\IntValue
 */
class IntValueTest extends AbstractTestCase
{
    public function dataConstruct()
    {
        return array(
            array(10, '10'),
            array('2', '2'),
            array('2type', '2'),
            array(null, '0'),
        );
    }

    /**
     * @dataProvider dataConstruct
     * @covers ::__construct
     */
    public function testConstruct($value, $expected)
    {
        $sql = new SQL\IntValue($value);

        $this->assertEquals($expected, $sql->getContent());
    }
}
