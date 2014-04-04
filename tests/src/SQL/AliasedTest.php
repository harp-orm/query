<?php namespace CL\Atlas\Test\SQL;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\SQL;

/**
 * @group sql.aliased
 */
class AliasedTest extends AbstractTestCase
{

    /**
     * @covers CL\Atlas\SQL\Aliased::factory
     */
    public function testFactory()
    {
        $expected = new SQL\Aliased('test', 'alias');

        $this->assertEquals($expected, SQL\Aliased::factory('test', 'alias'));
    }

    /**
     * @covers CL\Atlas\SQL\Aliased::__construct
     * @covers CL\Atlas\SQL\Aliased::getParameters
     * @covers CL\Atlas\SQL\Aliased::getAlias
     */
    public function testConstruct()
    {
        $aliased = new SQL\Aliased('SQL', 'ALIAS');

        $this->assertEquals('SQL', $aliased->getContent());
        $this->assertEquals('ALIAS', $aliased->getAlias());
        $this->assertNull($aliased->getParameters());

        $query = $this->getMock('CL\Atlas\Query\AbstractQuery');
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
