<?php namespace CL\Atlas\Test\SQL;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\SQL\SQL;

/**
 * @group sql
 */
class SQLTest extends AbstractTestCase {

    /**
     * @covers CL\Atlas\SQL\SQL::__construct
     * @covers CL\Atlas\SQL\SQL::content
     * @covers CL\Atlas\SQL\SQL::parameters
     * @covers CL\Atlas\SQL\SQL::__toString
     */
    public function testConstructAndGetters()
    {
        $params = array('param1', 'param2');
        $sql = new SQL('SQL STRING', $params);

        $this->assertEquals('SQL STRING', $sql->content());
        $this->assertEquals($params, $sql->parameters());
        $this->assertEquals('SQL STRING', $sql->__toString());

    }
}
