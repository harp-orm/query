<?php namespace Openbuildings\Cherry;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class SQL
{
	protected $parameters;
	protected $content;

	public function __invoke($content)
	{
		$params = array_slice(func_get_args(), 1);

		return new SQL($content, $params);
	}

	function __construct($content, array $parameters = NULL)
	{
		$this->content = (string) $content;

		if ($parameters)
		{
			$this->parameters = $parameters;
		}
	}

	public function content()
	{
		return $this->content;
	}

	public function parameters()
	{
		return $parameters;
	}
}
