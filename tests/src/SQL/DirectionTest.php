<?php

namespace Luna\Query\Test\SQL;

use Luna\Query\Test\AbstractTestCase;
use Luna\Query\SQL;

/**
 * @group sql.direction
 * @coversDefaultClass Luna\Query\SQL\Direction
 */
class DirectionTest extends AbstractTestCase
{
    /**
     * @covers ::__construct
     * @covers ::getDirection
     */
    public function testConstruct()
    {
        $direction = new SQL\Direction('name', 'DESC');

        $this->assertEquals('name', $direction->getContent());
        $this->assertEquals('DESC', $direction->getDirection());
    }
}
