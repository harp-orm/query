<?php namespace CL\Atlas\Test\SQL;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\SQL;

/**
 * @group sql
 */
class SQLTest extends AbstractTestCase
{
    /**
     * @covers CL\Atlas\SQL\SQL::__construct
     * @covers CL\Atlas\SQL\SQL::getContent
     * @covers CL\Atlas\SQL\SQL::getParameters
     * @covers CL\Atlas\SQL\SQL::__toString
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
