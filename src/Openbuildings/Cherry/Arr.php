<?php

namespace Openbuildings\Cherry;

/**
 * A helper class for array functions
 *
 * @package    Openbuildings\Cherry
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2013 OpenBuildings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class Arr {

	/**
	 * Retrieves multiple keys from an array, if the keys exist in it
	 *
	 * @param   array  $keys    array of keys to extract
	 * @param   array  $array   array to extract keys from
	 * @return  array
	 */
	public static function extract(array $keys, array $array)
	{
		$extracted = array();
		foreach ($keys as $key) 
		{
			if (isset($array[$key]))
			{
				$extracted[$key] = $array[$key];
			}
		}
		return $extracted;
	}
}