<?php

namespace Luna\Query\Test\SQL;

use Luna\Query\Test\AbstractTestCase;
use Luna\Query\SQL;

/**
 * @group sql
 * @coversDefaultClass Luna\Query\SQL\SQL
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
