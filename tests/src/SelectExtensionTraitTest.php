<?php

namespace Harp\Query\Test;

/**
 * @coversDefaultClass Harp\Query\SelectExtensionTrait
 *
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class SelectExtensionTraitTest extends AbstractTestCase
{
    public function getMockForMethod($method, $arguments)
    {
        $select = $this->getMock('Harp\Query\Select', [$method], [self::getDb()]);

        $methodMock = $select
            ->expects($this->once())
            ->method($method)
            ->will($this->returnSelf());

        if ($arguments) {
            $argumentConstraints = array_map(function ($argument) {
                return $this->equalTo($argument);
            }, $arguments);

            call_user_func_array([$methodMock, 'with'], $argumentConstraints);
        }

        return new SelectExtension($select);
    }

    public function dataSelectSetters()
    {
        return [
            ['column', ['name', 'alias']],
            ['column', ['name']],
            ['prependColumn', ['name', 'alias']],
            ['prependColumn', ['name']],
            ['where', ['name', 'val']],
            ['whereNot', ['name', 'val2']],
            ['whereRaw', ['test = ?', ['val2']]],
            ['whereIn', ['name', ['arr1', 'arr2']]],
            ['whereLike', ['name', 'val3']],
            ['having', ['name' ,'val']],
            ['havingNot', ['name', 'val']],
            ['havingIn', ['name', ['arr1', 'arr2']]],
            ['havingLike', ['name', 'val3']],
            ['group', ['name']],
            ['group', ['name', 'DESC']],
            ['order', ['name', 'ASC']],
            ['join', ['table', 'ON clause']],
            ['join', ['table', 'ON clause', 'type']],
            ['joinAliased', ['table', 'alias', ['col' => 'col']]],
            ['joinAliased', ['table', 'alias', ['col' => 'col'], 'type']],
            ['joinRels', [['test']]],
            ['limit', [12]],
            ['offset', [23]],
        ];
    }

    /**
     * @dataProvider dataSelectSetters
     *
     * @covers ::column
     * @covers ::prependColumn
     * @covers ::where
     * @covers ::whereNot
     * @covers ::whereIn
     * @covers ::whereRaw
     * @covers ::whereLike
     * @covers ::having
     * @covers ::havingNot
     * @covers ::havingIn
     * @covers ::havingLike
     * @covers ::group
     * @covers ::order
     * @covers ::join
     * @covers ::joinAliased
     * @covers ::joinRels
     * @covers ::limit
     * @covers ::offset
     */
    public function testSelectSetters($method, $arguments)
    {
        $selectExtension = $this->getMockForMethod($method, $arguments);

        $result = call_user_func_array([$selectExtension, $method], $arguments);

        $this->assertSame($selectExtension, $result);
    }

    public function dataClearInterface()
    {
        return [
            ['clearColumns'],
            ['clearWhere'],
            ['clearHaving'],
            ['clearGroup'],
            ['clearOrder'],
            ['clearJoin'],
            ['clearLimit'],
            ['clearOffset'],
        ];
    }

    /**
     * @dataProvider dataClearInterface
     *
     * @covers ::clearColumns
     * @covers ::clearWhere
     * @covers ::clearHaving
     * @covers ::clearGroup
     * @covers ::clearOrder
     * @covers ::clearJoin
     * @covers ::clearLimit
     * @covers ::clearOffset
     */
    public function testClearInterface($method)
    {
        $selectExtension = $this->getMockForMethod($method, []);

        $result = $selectExtension->$method();

        $this->assertSame($selectExtension, $result);
    }

}
