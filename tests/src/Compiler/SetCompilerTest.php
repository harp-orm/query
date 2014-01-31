<?php namespace CL\Atlas\Test\Compiler;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\Compiler\SetCompiler;
use CL\Atlas\Query\SelectQuery;
use CL\Atlas\SQL\SetSQL;
use CL\Atlas\SQL\SQL;

/**
 * @group compiler
 * @group compiler.set
 */
class SetCompilerTest extends AbstractTestCase {

    /**
     * @covers CL\Atlas\Compiler\SetCompiler::combine
     */
    public function testCombine()
    {
        $set1 = new SetSQL('name1', 'param1');
        $set2 = new SetSQL('name2', 'param2');

        $this->assertEquals('name1 = ?, name2 = ?', SetCompiler::combine(array($set1, $set2)));
    }

    public function dataRender()
    {
        $query = new SelectQuery();
        $query->from('table1')->where(array('name' => 'Peter'));

        $sql = new SQL('IF(name = "test", "big", "samll")');

        return array(
            array('name', 'param1', 'name = ?'),
            array('name', $query, 'name = (SELECT * FROM table1 WHERE (name = ?))'),
            array('name', $sql, 'name = IF(name = "test", "big", "samll")'),
        );
    }

    /**
     * @dataProvider dataRender
     * @covers CL\Atlas\Compiler\SetCompiler::render
     */
    public function testRender($name, $value, $expected)
    {
        $set = new SetSQL($name, $value);

        $this->assertEquals($expected, SetCompiler::render($set));
    }
}
