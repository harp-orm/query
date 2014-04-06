<?php

namespace CL\Atlas\Test\SQL;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\SQL;

/**
 * @group sql.direction
 */
class DirectionTest extends AbstractTestCase
{
    /**
     * @covers CL\Atlas\SQL\Direction::__construct
     * @covers CL\Atlas\SQL\Direction::getDirection
     */
    public function testConstruct()
    {
        $direction = new SQL\Direction('name', 'DESC');

        $this->assertEquals('name', $direction->getContent());
        $this->assertEquals('DESC', $direction->getDirection());
    }
}
