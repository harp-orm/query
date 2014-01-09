<?php namespace Openbuildings\Cherry;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Compiler_Select
{
	public function conditions(array $where)
	{
		$sql_fragments = array_map(array($this, 'sql'), $where);

		if (count($sql_fragments) > 1) 
		{
			return join(' AND ', array_map(array($this, 'braces'), $sql_fragments));
		}
		else
		{
			return reset($sql_fragments);
		}
	}

	public function braces($sql)
	{
		return '('.$sql.')';
	}

	public function sql(SQL $sql)
	{
		return $sql->content();
	}

	public function statement($statement, $content, $join = ', ')
	{
		if ($content) 
		{
			$content = is_array($content) ? join($join, $content) : $content;

			return $statement.' '.
		}
	}

	public function render(Query_Select $select)
	{
		return array(
			'SELECT',
			join(', ', $select->children('COLUMNS')),
			$this->statement('FROM', join(', ', $select->children('FROM'))),
			$this->conditions($select->children('WHERE')),
			$this->statement('WHERE', join(', ', $select->children('FROM'))),
	}
}
