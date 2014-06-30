<?php

namespace Harp\Query\Test\SQL;

use Harp\Query\Test\AbstractTestCase;
use Harp\Query\Query;
use Harp\Query\SQL;

/**
 * @group sql.condition
 * @coversDefaultClass Harp\Query\SQL\Condition
 */
class ConditionTest extends AbstractTestCase
{
    /**
     * @covers ::__construct
     * @covers ::getColumn
     */
    public function testConstruct()
    {
        $condition = new SQL\Condition('test1', '!= ?');

        $this->assertEquals('test1', $condition->getColumn());
        $this->assertEquals('!= ?', $condition->getContent());
    }
}
