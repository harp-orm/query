<?php

namespace Luna\Query\Test\SQL;

use Luna\Query\Test\AbstractTestCase;
use Luna\Query\SQL;

/**
 * @group sql.columns
 * @coversDefaultClass Luna\Query\SQL\Columns
 */
class ColumnsTest extends AbstractTestCase
{
    /**
     * @covers ::__construct
     * @covers ::all
     */
    public function testConstruct()
    {
        $columns = array(10, 20);
        $sql = new SQL\Columns($columns);

        $this->assertEquals(null, $sql->getContent());
        $this->assertEquals($columns, $sql->all());
    }
}
