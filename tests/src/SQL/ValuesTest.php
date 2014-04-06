<?php

namespace CL\Atlas\Test\SQL;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\SQL;

/**
 * @group sql.values
 */
class ValuesTest extends AbstractTestCase
{
    /**
     * @covers CL\Atlas\SQL\Values::__construct
     */
    public function testConstruct()
    {
        $values = array(10, 20);
        $sql = new SQL\Values($values);

        $this->assertEquals(null, $sql->getContent());
        $this->assertEquals($values, $sql->getParameters());
    }
}
