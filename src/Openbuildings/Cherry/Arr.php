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
				$converted[$key] = $value;
			}
			else
			{
				$converted[$value] = NULL;
			}
		}

		return $converted;
	}
}
