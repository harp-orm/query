<?php namespace CL\Cherry\Compiler;

use CL\Cherry\Str;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Compiler
{
	public static function toPlaceholders(array $array)
	{
		$placeholders = $array ? join(', ', array_fill(0, count($array), '?')) : '';

		return "($placeholders)";
	}

	public static function expression(array $parts)
	{
		return implode(' ', array_filter($parts));
	}

	public static function word($statement, $content)
	{
		return $content ? $statement.' '.$content : NULL;
	}

	public static function braced($content)
	{
		return $content ? "($content)" : NULL;
	}

	public static function humanize($sql, $parameters)
	{
		foreach ($parameters as & $param)
		{
			if (is_null($param))
			{
				$param = 'NULL';
			}
			elseif ( ! (is_int($param) OR is_bool($param)))
			{
				$param = "\"{$param}\"";
			}
		}
		return Str::replace('/\?/', $parameters, $sql);
	}
}
