<?php namespace Openbuildings\Cherry;

/**
 * Compile SQL query with new lines & identations
 * 
 * @package    Openbuildings\Cherry
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2013 OpenBuildings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class Compiler_Pretty extends Compiler {

	public function query(Query $statement)
	{
		$text = array($statement->keyword());

		if ($statement->children())
		{
			$text	= array_merge($text, $this->compile_array($statement->children()));
		}

		return implode("\n", $text);
	}
}