<?php

namespace Harp\Query\Test\SQL;

use Harp\Query\Test\AbstractTestCase;
use Harp\Query\SQL;

/**
 * @group sql
 * @coversDefaultClass Harp\Query\SQL\SQL
 */
class SQLTest extends AbstractTestCase
{
    /**
     * @covers ::__construct
     * @covers ::getContent
     * @covers ::getParameters
     * @covers ::__toString
     */
    public function testConstructAndGetters()
    {
        $params = array('param1', 'param2');
        $sql = new SQL\SQL('SQL STRING', $params);

        $this->assertEquals('SQL STRING', $sql->getContent());
        $this->assertEquals($params, $sql->getParameters());
        $this->assertEquals('SQL STRING', $sql->__toString());

    }
}
