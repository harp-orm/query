<?php
namespace Openbuildings\Cherry;

class Arr {

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