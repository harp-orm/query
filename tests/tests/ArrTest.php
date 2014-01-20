<?php

use Openbuildings\Cherry\Arr;
use Openbuildings\Cherry\SQL_Aliased;
use Openbuildings\Cherry\Query_Select;

/**
 * @group arr
 */
class ArrTest extends Testcase_Extended {

	public function dataToAssoc()
	{
		return array(
			array(array('name1', 'name2'), array('name1' => NULL, 'name2' => NULL)),
			array(array('name1', 'name2' => 'val2'), array('name1' => NULL, 'name2' => 'val2')),
			array(array('name1', 'name2' => new stdClass), array('name1' => NULL, 'name2' => new stdClass)),
		);
	}

	/**
	 * @dataProvider dataToAssoc
	 * @covers Openbuildings\Cherry\Arr::toAssoc
	 */
	public function testToAssoc($array, $expected)
	{
		$this->assertEquals($expected, Arr::toAssoc($array));
	}

	public function dataToArray()
	{
		return array(
			array(array('name1', 'name2'), array('name1', 'name2')),
			array(array('name1'), array('name1')),
			array('name1', array('name1')),
			array(new stdClass, array(new stdClass)),
		);
	}

	/**
	 * @dataProvider dataToArray
	 * @covers Openbuildings\Cherry\Arr::toArray
	 */
	public function testToArray($array, $expected)
	{
		$this->assertEquals($expected, Arr::toArray($array));
	}

	public function dataToObjects()
	{
		$test1 = array('test1', NULL);
		$test2 = array('test2', NULL);
		$alias1 = array('test1', 'alias1');
		$alias2 = array('test2', 'alias2');
		$alias3 = array(new Query_Select, 'alias3');
		$sql_alias = new SQL_Aliased('test3', 'alias3');

		return array(
			array('test1', 'alias1', array($alias1)),
			array(new Query_Select, 'alias3', array($alias3)),
			array('test1', NULL, array($test1)),
			array(array('test1'), NULL, array($test1)),
			array(array('test1', 'test2'), NULL, array($test1, $test2)),
			array(array('test1', 'test2' => 'alias2'), NULL, array($test1, $alias2)),
			array(array('test1', 'test2' => 'alias2', $sql_alias), NULL, array($test1, $alias2, $sql_alias)),
		);
	}

	/**
	 * @dataProvider dataToObjects
	 * @covers Openbuildings\Cherry\Arr::toObjects
	 */
	public function testToObjects($array, $argument, array $expected)
	{
		$object = $this->getMock('stdClass', array('callback'));

		$index = 0;
		foreach ($expected as $value)
		{
			if ( ! is_object($value))
			{
				$object
					->expects($this->at($index++))
					->method('callback')
					->with($this->equalTo($value[0]), $this->equalTo($value[1]))
					->will($this->returnValue($value));
			}
		}

		$this->assertEquals($expected, Arr::toObjects($array, $argument, array($object, 'callback')));
	}


	public function dataMap()
	{
		return array(
			array(array('name1', 'name2'), function($item){ return $item.'2';}, array('name12', 'name22')),
			array(NULL, function($item){ return $item.'2';}, NULL),
		);
	}

	/**
	 * @dataProvider dataMap
	 * @covers Openbuildings\Cherry\Arr::map
	 */
	public function testMap($array, $collection, $expected)
	{
		$this->assertEquals($expected, Arr::map($collection, $array));
	}

	public function dataJoin()
	{
		return array(
			array('|', array('name1', 'name2', 'name3'), 'name1|name2|name3'),
			array('|', NULL, NULL),
		);
	}

	/**
	 * @dataProvider dataJoin
	 * @covers Openbuildings\Cherry\Arr::join
	 */
	public function testJoin($separator, $array, $expected)
	{
		$this->assertEquals($expected, Arr::join($separator, $array));
	}
	public function dataFlatten()
	{
		return array(
			array(array('name1' => 'test1', 'name2' => 'test2'), array('name1' => 'test1', 'name2' => 'test2')),
			array(array('name1', 'name2'), array('name1', 'name2')),
			array(array('name1', 'name2', array('test1', 'test2', array('part1'), 'test3')), array('name1', 'name2', 'test1', 'test2', 'part1', 'test3')),
		);
	}

	/**
	 * @dataProvider dataFlatten
	 * @covers Openbuildings\Cherry\Arr::flatten
	 */
	public function testFlatten($array, $expected)
	{
		$this->assertEquals($expected, Arr::flatten($array));
	}
}
