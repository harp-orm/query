<?php namespace Openbuildings\Cherry\Query;

use Openbuildings\Cherry\Arr;
use Openbuildings\Cherry\Compiler\InsertCompiler;
use Openbuildings\Cherry\SQL\SetSQL;
use Openbuildings\Cherry\SQL\ValuesSQL;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class InsertQuery extends Query
{
	public function type($type)
	{
		$this->children[Query::TYPE] = $type;
		return $this;
	}

	public function into($table)
	{
		$this->children[Query::TABLE] = $table;

		return $this;
	}

	public function columns($columns)
	{
		$this->addChildren(Query::COLUMNS, Arr::toArray($columns));

		return $this;
	}

	public function values(array $values)
	{
		$this->children[Query::VALUES] []= new ValuesSQL($values);

		return $this;
	}

	public function set(array $values)
	{
		foreach ($values as $column => $value)
		{
			$this->children[Query::SET] []= new SetSQL($column, $value);
		}

		return $this;
	}

	public function select(SelectQuery $select)
	{
		$this->children[Query::SELECT] = $select;
		return $this;
	}

	public function sql()
	{
		return InsertCompiler::render($this);
	}
}
