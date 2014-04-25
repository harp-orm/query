<?php

namespace CL\Atlas\Query;

use CL\Atlas\Compiler;
use CL\Atlas\SQL;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Insert extends AbstractQuery
{
    /**
     * @var SQL\Aliased|null
     */
    protected $table;

    /**
     * @var SQL\Columns|null
     */
    protected $columns;

    /**
     * @var SQL\Set[]|null
     */
    protected $set;

    /**
     * @var SQL\Values[]|null
     */
    protected $values;

    /**
     * @var Select|null
     */
    protected $select;

    /**
     * @return SQL\Aliased|null
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @return SQL\Columns|null
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @return SQL\Set[]|null
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * @return SQL\Values[]|null
     */
    public function getSet()
    {
        return $this->set;
    }

    /**
     * @return Select|null
     */
    public function getSelect()
    {
        return $this->select;
    }

    public function into($table)
    {
        $this->table = new SQL\Aliased($table);

        return $this;
    }

    public function clearTable()
    {
        $this->table = null;

        return $this;
    }

    public function columns(array $columns)
    {
        $this->columns = new SQL\Columns($columns);

        return $this;
    }

    public function clearColumns()
    {
        $this->columns = null;

        return $this;
    }

    public function values(array $values)
    {
        $this->values []= new SQL\Values($values);

        return $this;
    }

    public function clearValues()
    {
        $this->values = null;

        return $this;
    }

    public function set(array $values)
    {
        foreach ($values as $column => $value) {
            $this->set []= new SQL\Set($column, $value);
        }

        return $this;
    }

    public function clearSet()
    {
        $this->set = null;

        return $this;
    }

    public function select(Select $select)
    {
        $this->select = $select;

        return $this;
    }

    public function clearSelect()
    {
        $this->select = null;

        return $this;
    }

    /**
     * @return string
     */
    public function sql()
    {
        return Compiler\Insert::render($this);
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return Compiler\Insert::parameters($this);
    }
}
