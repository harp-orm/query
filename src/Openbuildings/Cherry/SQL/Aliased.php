<?php namespace Openbuildings\Cherry;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class SQL_Aliased extends SQL
{
	protected $alias;

	public static function factory($content, $alias = NULL)
	{
		return new SQL_Aliased($content, $alias);
	}

	function __construct($content, $alias = NULL)
	{
		$this->content = $content;
		$this->alias = $alias;
	}

	public function parameters()
	{
		if ($this->content instanceof Query)
		{
			return $this->content->parameters();
		}
	}

	public function alias()
	{
		return $this->alias;
	}
}
