<?php

namespace Harp\Query\Test;

use Harp\Query\SQL;

/**
 * @group query
 * @coversDefaultClass Harp\Query\AbstractOrderLimit
 *
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class AbstractOrderLimitTest extends AbstractTestCase
{
    /**
     * @covers ::order
     * @covers ::getOrder
     * @covers ::setOrder
     * @covers ::clearOrder
     */
    public function testOrder()
    {
        $query = $this->getMock('Harp\Query\AbstractOrderLimit', array('sql', 'getParameters'));

        $query
            ->order('col1')
            ->order('col2', 'dir2');

        $expected = array(
            new SQL\Direction('col1'),
            new SQL\Direction('col2', 'dir2'),
        );

        $this->assertEquals($expected, $query->getOrder());

        $query->clearOrder();

        $this->assertEmpty($query->getOrder());

        $query->setOrder($expected);

        $this->assertEquals($expected, $query->getOrder());
    }


    /**
     * @covers ::limit
     * @covers ::getLimit
     * @covers ::setLimit
     * @covers ::clearLimit
     */
    public function testLimit()
    {
        $query = $this->getMock('Harp\Query\AbstractOrderLimit', array('sql', 'getParameters'));

        $query->limit(20);

        $expected = new SQL\IntValue(20);

        $this->assertEquals($expected, $query->getLimit());

        $query->clearLimit();

        $this->assertEmpty($query->getLimit());

        $query->setLimit($expected);

        $this->assertEquals($expected, $query->getLimit());
    }
}
