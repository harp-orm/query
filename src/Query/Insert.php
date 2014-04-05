<?php namespace CL\Atlas\Query;

use CL\Atlas\Arr;
use CL\Atlas\Compiler;
use CL\Atlas\SQL;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Insert extends AbstractQuery
{
    public $type;
    public $table;
    public $columns;
    public $set;
    public $values;
    public $select;

    public function getType()
    {
        return $this->type;
    }

    public function getTable()
    {
        return $this->table;
    }

    public function getColumns()
    {
        return $this->columns;
    }

    public function getValues()
    {
        return $this->values;
    }

    public function getSet()
    {
        return $this->set;
    }

    public function getSelect()
    {
        return $this->select;
    }

    public function type($type)
    {
        $this->type = new SQL\SQL($type);

        return $this;
    }

    public function into($table)
    {
        $this->table = new SQL\Aliased($table);

        return $this;
    }

    public function columns(array $columns)
    {
        $this->columns = new SQL\Columns($columns);

        return $this;
    }

    public function values(array $values)
    {
        $this->values []= new SQL\Values($values);

        return $this;
    }

    public function set(array $values)
    {
        foreach ($values as $column => $value) {
            $this->set []= new SQL\Set($column, $value);
        }

        return $this;
    }

    public function select(Select $select)
    {
        $this->select = $select;

        return $this;
    }

    public function sql()
    {
        return Compiler\Insert::render($this);
    }

    public function getParameters()
    {
        return Compiler\Insert::parameters($this);
    }

}
