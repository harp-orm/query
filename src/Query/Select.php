<?php

namespace CL\Atlas\Query;

use CL\Atlas\Compiler;
use CL\Atlas\SQL;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Select extends AbstractQuery
{
    /**
     * @var SQL\SQL
     */
    protected $type;

    /**
     * @var SQL\Aliased[]
     */
    protected $columns;

    /**
     * @var SQL\Aliased[]
     */
    protected $from;

    /**
     * @var SQL\Join[]
     */
    protected $join;

    /**
     * @var SQL\Condition[]
     */
    protected $where;

    /**
     * @var SQL\Direction[]
     */
    protected $group;

    /**
     * @var SQL\Condition[]
     */
    protected $having;

    /**
     * @var SQL\Direction[]
     */
    protected $order;

    /**
     * @var SQL\IntVal
     */
    protected $limit;

    /**
     * @var SQL\IntVal
     */
    protected $offset;

    /**
     * @return SQL\SQL|null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return SQL\Aliased[]|null
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @return SQL\Aliased[]|null
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return SQL\Join[]|null
     */
    public function getJoin()
    {
        return $this->join;
    }

    /**
     * @return SQL\Condition[]|null
     */
    public function getWhere()
    {
        return $this->where;
    }

    /**
     * @return SQL\Direction[]|null
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @return SQL\Condition[]|null
     */
    public function getHaving()
    {
        return $this->having;
    }

    /**
     * @return SQL\Direction[]|null
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @return SQL\IntVal|null
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @return SQL\IntVal|null
     */
    public function getOffset()
    {
        return $this->offset;
    }


    public function type($type)
    {
        $this->type = new SQL\SQL($type);

        return $this;
    }

    public function column($column, $alias = null)
    {
        $this->columns []= new SQL\Aliased($column, $alias);

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

    public function group($column, $direction = null)
    {
        $this->group []= new SQL\Direction($column, $direction);

        return $this;
    }

    public function having(array $conditions)
    {
        $this->having []= new SQL\ConditionArray($conditions);

        return $this;
    }

    public function havingRaw($conditions)
    {
        $parameters = array_slice(func_get_args(), 1);
        $this->having []= new SQL\Condition($conditions, $parameters);

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

    public function offset($offset)
    {
        $this->offset = new SQL\IntValue($offset);

        return $this;
    }

    public function sql()
    {
        return Compiler\Select::render($this);
    }

    public function getParameters()
    {
        return Compiler\Select::parameters($this);
    }
}
