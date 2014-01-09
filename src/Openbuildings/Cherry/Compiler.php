<?php namespace Openbuildings\Cherry;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Compiler
{
	protected $children;

	public static function select()
	{
		return new Query_Select;
	}

	public function children()
	{
		return $this->children;
	}

	public function parameters()
	{
		$parameters = array();

		if ($this->children)
		{
			foreach ($this->children as $child) 
			{
				if (($child_parameters = $child->parameters()))
				{
					$parameters = array_merge($parameters, $child_parameters);
				}
			}
		}

		return $parameters;
	}
}
