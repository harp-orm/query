<?php namespace Openbuildings\Cherry;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Compiler
{
	public static function to_placeholders(array $array)
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

}
