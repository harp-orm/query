<?php namespace Openbuildings\Cherry\SQL;

use Openbuildings\Cherry\Parametrised;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class SQL implements Parametrised {

	protected $parameters;
	protected $content;

	function __construct($content, array $parameters = NULL)
	{
		$this->content = (string) $content;

		if ($parameters)
		{
			$this->parameters = $parameters;
		}
	}

	public function __toString()
	{
		return $this->content();
	}

	public function content()
	{
		return $this->content;
	}

	public function parameters()
	{
		return $this->parameters;
	}
}
