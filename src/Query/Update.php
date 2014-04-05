<?php

namespace CL\Atlas\Query;

use CL\Atlas\Compiler;
use CL\Atlas\SQL;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Update extends AbstractQuery
{
    /**
     * @var SQL\SQL
     */
    protected $type;

    /**
     * @var SQL\Aliased[]
     */
    protected $table;

    /**
     * @var SQL\Join[]
     */
    protected $join;

    /**
     * @var SQL\Set[]
     */
    protected $set;

    /**
     * @var SQL\Condition[]
     */
    protected $where;

    /**
     * @var SQL\Direction[]
     */
    protected $order;

    /**
     * @var SQL\IntVal
     */
    protected $limit;

    /**
     * @return SQL\SQL
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return SQL\Aliased[]
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @return SQL\Join[]
     */
    public function getJoin()
    {
        return $this->join;
    }

    /**
     * @return SQL\Set[]
     */
    public function getSet()
    {
        return $this->set;
    }

    /**
     * @return SQL\Condition[]
     */
    public function getWhere()
    {
        return $this->where;
    }

    /**
     * @return SQL\Direction[]
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @return SQL\IntVal
     */
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
