<?php

namespace Luna\Query\Test\SQL;

use Luna\Query\Test\AbstractTestCase;
use Luna\Query\SQL;

/**
 * @group sql.values
 * @coversDefaultClass Luna\Query\SQL\Values
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
