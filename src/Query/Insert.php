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
    public function type($type)
    {
        $this->children[AbstractQuery::TYPE] = $type;

        return $this;
    }

    public function into($table)
    {
        $this->children[AbstractQuery::TABLE] = $table;

        return $this;
    }

    public function columns(array $columns)
    {
        $this->addChildren(AbstractQuery::COLUMNS, $columns);

        return $this;
    }

    public function values(array $values)
    {
        $this->children[AbstractQuery::VALUES] []= new SQL\Values($values);

        return $this;
    }

    public function set(array $values)
    {
        foreach ($values as $column => $value) {
            $this->children[AbstractQuery::SET] []= new SQL\Set($column, $value);
        }

        return $this;
    }

    public function select(Select $select)
    {
        $this->children[AbstractQuery::SELECT] = $select;

        return $this;
    }

    public function sql()
    {
        return Compiler\Insert::render($this);
    }
}
