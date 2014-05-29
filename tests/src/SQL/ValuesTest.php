<?php

namespace Harp\Query\Test\SQL;

use Harp\Query\Test\AbstractTestCase;
use Harp\Query\SQL;

/**
 * @group sql.values
 * @coversDefaultClass Harp\Query\SQL\Values
 */
class ValuesTest extends AbstractTestCase
{
    /**
     * @covers ::__construct
     */
    public function testConstruct()
    {
        $values = array(10, 20);
        $sql = new SQL\Values($values);

        $this->assertEquals(null, $sql->getContent());
        $this->assertEquals($values, $sql->getParameters());
    }
}
