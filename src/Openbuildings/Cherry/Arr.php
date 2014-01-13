<?php

namespace Openbuildings\Cherry;

/**
 * Extend exception to allow variables 
 *
 * @author     Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Arr
{
	public static function to_assoc(array $array)
	{
		$converted = array();

		foreach ($array as $key => $value)
		{
			if (is_numeric($key)) 
			{
				$converted[$value] = NULL;
			}
			else
			{
				$converted[$key] = $value;
			}
		}

		return $converted;
	}

	public function has_array(array $array)
	{
		return (bool) array_filter($array, function($param){ 
			return is_array($param);
		});
	}

	public function replace_placeholders($content, array $array)
	{
		$i=0;
		return preg_replace_callback('/\?/', function($matches) use ($array, & $i) {
			return $array[$i++];
		}, $content);
	}

	public function flatten(array $array)
	{
		$result = array();

		array_walk_recursive($array, function($value, $key) use ( & $result) { 
			if (is_numeric($key) OR is_object($value)) 
			{
				$result[] = $value; 
			}
			else
			{
				$result[$key] = $value;
			}
		});

		return $result;
	}
}
