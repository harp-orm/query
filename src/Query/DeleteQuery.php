<?php namespace CL\Cherry\Query;

use CL\Cherry\Arr;
use CL\Cherry\Compiler\DeleteCompiler;
use CL\Cherry\Query\Query;
use CL\Cherry\SQL\JoinSQL;
use CL\Cherry\SQL\ConditionSQL;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class DeleteQuery extends Query
{
	public function type($type)
	{
		$this->children[Query::TYPE] = $type;
		return $this;
	}

	public function table($table)
	{
		$this->addChildren(Query::TABLE, Arr::toArray($table));

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

	public function sql()
	{
		return DeleteCompiler::render($this);
	}
}
