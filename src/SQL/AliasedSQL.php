<?php namespace Openbuildings\Cherry\SQL;

use Openbuildings\Cherry\Parametrised;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class AliasedSQL extends SQL
{
	protected $alias;

	public static function factory($content, $alias = NULL)
	{
		return new AliasedSQL($content, $alias);
	}

	function __construct($content, $alias = NULL)
	{
		$this->content = $content;
		$this->alias = $alias;
	}

	public function parameters()
	{
		if ($this->content() instanceof Parametrised)
		{
			return $this->content()->parameters();
		}
	}

	public function alias()
	{
		return $this->alias;
	}
}
