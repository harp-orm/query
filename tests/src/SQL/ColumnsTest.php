<?php namespace CL\Atlas\Test\SQL;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\SQL;

/**
 * @group sql.columns
 */
class ColumnsTest extends AbstractTestCase
{
    /**
     * @covers CL\Atlas\SQL\Columns::__construct
     * @covers CL\Atlas\SQL\Columns::all
     */
    public function testConstruct()
    {
        $columns = array(10, 20);
        $sql = new SQL\Columns($columns);

        $this->assertEquals(null, $sql->getContent());
        $this->assertEquals($columns, $sql->all());
    }
}
