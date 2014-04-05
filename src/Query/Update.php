<?php namespace CL\Atlas\Query;

use CL\Atlas\Compiler;
use CL\Atlas\SQL;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Update extends AbstractQuery
{
    protected $type;
    protected $table;
    protected $join;
    protected $set;
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

    public function getJoin()
    {
        return $this->join;
    }

    public function getSet()
    {
        return $this->set;
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

    public function table($table, $alias = null)
    {
        $this->table []= new SQL\Aliased($table, $alias);

        return $this;
    }

    public function join($table, $condition, $type = null)
    {
        $this->join []= new SQL\Join($table, $condition, $type);

        return $this;
    }

    public function set(array $values)
    {
        foreach ($values as $column => $value) {
            $this->set []= new SQL\Set($column, $value);
        }

        return $this;
    }

    public function where(array $conditions)
    {
        $this->where []= new SQL\ConditionArray($conditions);

        return $this;
    }

    public function whereRaw($conditions)
    {
        $parameters = array_slice(func_get_args(), 1);
        $this->where []= new SQL\Condition($conditions, $parameters);

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
        return Compiler\Update::render($this);
    }

    public function getParameters()
    {
        return Compiler\Update::parameters($this);
    }

}
