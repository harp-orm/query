<?php namespace CL\Atlas\Query;

use CL\Atlas\Arr;
use CL\Atlas\Compiler\DeleteCompiler;
use CL\Atlas\Query\Query;
use CL\Atlas\SQL\JoinSQL;
use CL\Atlas\SQL\ConditionSQL;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
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

    public function from($table, $alias = null)
    {
        $this->addChildrenObjects(Query::FROM, $table, $alias, 'CL\Atlas\SQL\AliasedSQL::factory');

        return $this;
    }

    public function join($table, $condition, $type = null)
    {
        $this->children[Query::JOIN] []= new JoinSQL($table, $condition, $type);

        return $this;
    }

    public function where($where)
    {
        $this->children[Query::WHERE] []= new ConditionSQL($where, array_slice(func_get_args(), 1));

        return $this;
    }

    public function order($column, $direction = null)
    {
        $this->addChildrenObjects(Query::ORDER_BY, $column, $direction, 'CL\Atlas\SQL\DirectionSQL::factory');

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
