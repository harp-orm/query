<?php namespace CL\Atlas\SQL;

use CL\Atlas\Parametrised;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
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
