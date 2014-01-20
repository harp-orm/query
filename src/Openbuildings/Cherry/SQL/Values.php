<?php namespace Openbuildings\Cherry;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class SQL_Values extends SQL
{
	function __construct(array $values)
	{
		parent::__construct(NULL, $values);
	}
}
