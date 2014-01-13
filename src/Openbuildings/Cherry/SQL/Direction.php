<?php namespace Openbuildings\Cherry;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class SQL_Direction extends SQL
{
	function __construct($statement, $direction = NULL)
	{
		if ($direction) 
		{
			$statement = "$statement $direction";
		}

		parent::__construct($statement);
	}
}
