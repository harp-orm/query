<?php namespace CL\Cherry\SQL;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class ConditionSQL extends SQL
{

	function __construct($content, array $parameters = NULL)
	{
		if (is_array($content))
		{
			$statements = array();

			foreach ($content as $column => $value)
			{
				if (is_array($value))
				{
					$statements []= "$column IN ?";
				}
				elseif (is_null($value))
				{
					$statements []= "$column IS ?";
				}
				else
				{
					$statements []= "$column = ?";
				}

				$parameters []= $value;
			}

			$content = implode(' AND ', $statements);
		}

		parent::__construct($content, $parameters);
	}
}
