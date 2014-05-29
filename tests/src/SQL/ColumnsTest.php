<?php

namespace Harp\Query\Test\SQL;

use Harp\Query\Test\AbstractTestCase;
use Harp\Query\SQL;

/**
 * @group sql.columns
 * @coversDefaultClass Harp\Query\SQL\Columns
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
