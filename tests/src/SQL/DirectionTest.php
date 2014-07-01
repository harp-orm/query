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
     * @covers ::getParameters
     */
    public function testConstruct()
    {
        $direction = new SQL\Direction('name', 'DESC');

        $this->assertEquals('name', $direction->getContent());
        $this->assertEquals('DESC', $direction->getDirection());
        $this->assertNull($direction->getParameters());

        $sql = new SQL\SQL('test ?', array('test'));

        $direction = new SQL\Direction($sql, 'DESC');
        $this->assertSame($sql, $direction->getContent());
        $this->assertSame(array('test'), $direction->getParameters());
        $this->assertEquals('DESC', $direction->getDirection());
    }
}
