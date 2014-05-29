<?php

namespace Harp\Query\Test\SQL;

use Harp\Query\Test\AbstractTestCase;
use Harp\Query\SQL;

/**
 * @group sql.direction
 * @coversDefaultClass Harp\Query\SQL\Direction
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
