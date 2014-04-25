<?php

namespace CL\Atlas\Query;

use CL\Atlas\Compiler;
use CL\Atlas\SQL;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Select extends AbstractWhere
{
    /**
     * @var SQL\Aliased[]|null
     */
    protected $columns;

    /**
     * @var SQL\Aliased[]|null
     */
    protected $from;

    /**
     * @var SQL\Direction[]|null
     */
    protected $group;

    /**
     * @var SQL\Condition[]|null
     */
    protected $having;

    /**
     * @var SQL\IntVal|null
     */
    protected $offset;

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
     * @return SQL\IntVal|null
     */
    public function getOffset()
    {
        return $this->offset;
    }

    public function clearColumns()
    {
        $this->columns = null;

        return $this;
    }

    public function clearFrom()
    {
        $this->from = null;

        return $this;
    }

    public function clearGroup()
    {
        $this->group = null;

        return $this;
    }

    public function clearHaving()
    {
        $this->having = null;

        return $this;
    }

    public function clearOffset()
    {
        $this->offset = null;

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

    public function havingRaw($conditions, array $parameters = null)
    {
        $this->having []= new SQL\Condition($conditions, $parameters);

        return $this;
    }

    public function offset($offset)
    {
        $this->offset = new SQL\IntValue($offset);

        return $this;
    }

    /**
     * @return string
     */
    public function sql()
    {
        return Compiler\Select::render($this);
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return Compiler\Select::parameters($this);
    }
}
