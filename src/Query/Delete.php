<?php namespace CL\Atlas\Query;

use CL\Atlas\Arr;
use CL\Atlas\Compiler;
use CL\Atlas\SQL;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Delete extends AbstractQuery
{
    public function type($type)
    {
        $this->children[AbstractQuery::TYPE] = (string) $type;

        return $this;
    }

    public function table($table)
    {
        $this->children[AbstractQuery::TABLE] []= (string) $table;

        return $this;
    }

    public function from($table, $alias = null)
    {
        $this->children[AbstractQuery::FROM] []= new SQL\Aliased($table, $alias);

        return $this;
    }

    public function join($table, $condition, $type = null)
    {
        $this->children[AbstractQuery::JOIN] []= new SQL\Join($table, $condition, $type);

        return $this;
    }

    public function where(array $condition)
    {
        $this->children[AbstractQuery::WHERE] []= new SQL\ConditionArray($condition);

        return $this;
    }

    public function whereRaw($condition)
    {
        $this->children[AbstractQuery::WHERE] []= new SQL\Condition($condition, array_slice(func_get_args(), 1));

        return $this;
    }

    public function order($column, $direction = null)
    {
        $this->children[AbstractQuery::ORDER_BY] []= new SQL\Direction($column, $direction);

        return $this;
    }

    public function limit($limit)
    {
        $this->children[AbstractQuery::LIMIT] = (int) $limit;

        return $this;
    }

    public function sql()
    {
        return Compiler\Delete::render($this);
    }
}
