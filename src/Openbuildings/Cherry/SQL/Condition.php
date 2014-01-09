<?php namespace Openbuildings\Cherry;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class SQL_Condition extends SQL
{
	function __construct(array $array)
	{
		$content = array();
		
		foreach ($array as $column => $value)
		{
			$content [] = "$column = ?";
		}

		parent::__construct(join(' AND ', $content), array_values($array));
	}
}
