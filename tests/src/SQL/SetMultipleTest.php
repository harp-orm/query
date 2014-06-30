<?php

namespace Harp\Query\Test\SQL;

use Harp\Query\Test\AbstractTestCase;
use Harp\Query;
use Harp\Query\SQL;
use Harp\Query\Compiler\Compiler;

/**
 * @group sql.set_multiple
 * @coversDefaultClass Harp\Query\SQL\SetMultiple
 */
class SetMultipleTest extends AbstractTestCase
{
    /**
     * @covers ::__construct
     * @covers ::getKey
     * @covers ::getParameters
     */
    public function testConstruct()
    {
        $set = new SQL\SetMultiple('col_name', array(1 => 'test', 10 => 'test2'), 'guid');

        $this->assertEquals('col_name', $set->getContent());
        $this->assertEquals(array(1 => 'test', 10 => 'test2'), $set->getValue());
        $this->assertEquals(array(1, 'test', 10, 'test2'), $set->getParameters());
        $this->assertEquals('guid', $set->getKey());
    }
}
