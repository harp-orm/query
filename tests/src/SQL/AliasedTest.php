<?php

namespace Harp\Query\Test\SQL;

use Harp\Query\Test\AbstractTestCase;
use Harp\Query\SQL;

/**
 * @group sql.aliased
 * @coversDefaultClass Harp\Query\SQL\Aliased
 */
class AliasedTest extends AbstractTestCase
{
    /**
     * @covers ::__construct
     * @covers ::getParameters
     * @covers ::getAlias
     */
    public function testConstruct()
    {
        $aliased = new SQL\Aliased('SQL', 'ALIAS');

        $this->assertEquals('SQL', $aliased->getContent());
        $this->assertEquals('ALIAS', $aliased->getAlias());
        $this->assertNull($aliased->getParameters());

        $query = $this->getMock('Harp\Query\AbstractQuery');
        $query
            ->expects($this->once())
            ->method('getParameters')
            ->will($this->returnValue(array('val')));

        $aliasedQuery = new SQL\Aliased($query, 'query_alias');

        $this->assertSame($query, $aliasedQuery->getContent());
        $this->assertEquals('query_alias', $aliasedQuery->getAlias());
        $this->assertEquals(array('val'), $aliasedQuery->getParameters());
    }
}
