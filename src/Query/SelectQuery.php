<?php namespace CL\Cherry\Query;

use CL\Cherry\Compiler\SelectCompiler;
use CL\Cherry\Query\Query;
use CL\Cherry\SQL\ConditionSQL;
use CL\Cherry\SQL\JoinSQL;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class SelectQuery extends Query
{
	public function type($type)
	{
		$this->children[Query::TYPE] = $type;
		return $this;
	}

	public function columns($column, $alias = NULL)
	{
		$this->addChildrenObjects(Query::COLUMNS, $column, $alias, 'CL\Cherry\SQL\AliasedSQL::factory');

		return $this;
	}

	public function from($table, $alias = NULL)
	{
		$this->addChildrenObjects(Query::FROM, $table, $alias, 'CL\Cherry\SQL\AliasedSQL::factory');

		return $this;
	}

	public function join($table, $condition, $type = NULL)
	{
		$this->children[Query::JOIN] []= new JoinSQL($table, $condition, $type);
		return $this;
	}

	public function where($where)
	{
		$this->children[Query::WHERE] []= new ConditionSQL($where, array_slice(func_get_args(), 1));

		return $this;
	}

	public function group($column, $direction = NULL)
	{
		$this->addChildrenObjects(Query::GROUP_BY, $column, $direction, 'CL\Cherry\SQL\DirectionSQL::factory');

		return $this;
	}

	public function having($having)
	{
		$this->children[Query::HAVING] []= new ConditionSQL($having, array_slice(func_get_args(), 1));

		return $this;
	}

	public function order($column, $direction = NULL)
	{
		$this->addChildrenObjects(Query::ORDER_BY, $column, $direction, 'CL\Cherry\SQL\DirectionSQL::factory');

		return $this;
	}

	public function limit($limit)
	{
		$this->children[Query::LIMIT] = (int) $limit;
		return $this;
	}

	public function offset($offset)
	{
		$this->children[Query::OFFSET] = (int) $offset;
		return $this;
	}

	public function sql()
	{
		return SelectCompiler::render($this);
	}
}
