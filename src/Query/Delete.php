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
    protected $type;
    protected $table;
    protected $from;
    protected $join;
    protected $where;
    protected $order;
    protected $limit;

    public function getType()
    {
        return $this->type;
    }

    public function getTable()
    {
        return $this->table;
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function getJoin()
    {
        return $this->join;
    }

    public function getWhere()
    {
        return $this->where;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function getLimit()
    {
        return $this->limit;
    }

    public function type($type)
    {
        $this->type = new SQL\SQL($type);

        return $this;
    }

    public function table($table)
    {
        $this->table []= new SQL\Aliased($table);

        return $this;
    }

    public function from($table, $alias = null)
    {
        $this->from []= new SQL\Aliased($table, $alias);

        return $this;
    }

    public function join($table, $condition, $type = null)
    {
        $this->join []= new SQL\Join($table, $condition, $type);

        return $this;
    }

    public function where(array $condition)
    {
        $this->where []= new SQL\ConditionArray($condition);

        return $this;
    }

    public function whereRaw($condition)
    {
        $parameters = array_slice(func_get_args(), 1);
        $this->where []= new SQL\Condition($condition, $parameters);

        return $this;
    }

    public function order($column, $direction = null)
    {
        $this->order []= new SQL\Direction($column, $direction);

        return $this;
    }

    public function limit($limit)
    {
        $this->limit = new SQL\IntValue($limit);

        return $this;
    }

    public function sql()
    {
        return Compiler\Delete::render($this);
    }

    public function getParameters()
    {
        return Compiler\Delete::parameters($this);
    }
}
