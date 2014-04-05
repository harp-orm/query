<?php namespace CL\Atlas\Test\SQL;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\SQL;

/**
 * @group sql.int_value
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
     * @covers CL\Atlas\SQL\IntValue::__construct
     * @dataProvider dataConstruct
     */
    public function testConstruct($value, $expected)
    {
        $sql = new SQL\IntValue($value);

        $this->assertEquals($expected, $sql->getContent());
    }
}
