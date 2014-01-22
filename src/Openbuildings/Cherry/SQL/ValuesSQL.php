<?php namespace Openbuildings\Cherry\SQL;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class ValuesSQL extends SQL
{
	function __construct(array $values)
	{
		parent::__construct(NULL, $values);
	}
}
