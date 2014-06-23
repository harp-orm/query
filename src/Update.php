<?php

namespace Harp\Query;

use Harp\Query\Compiler;
use Harp\Query\SQL;
use Harp\Query\Arr;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Update extends AbstractWhere
{
    /**
     * @var SQL\Aliased[]|null
     */
    protected $table;

    /**
     * @var SQL\Set[]|null
     */
    protected $set;

    /**
     * @return SQL\Aliased[]|null
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param SQL\Aliased[] $table
     */
    public function setTable(array $table)
    {
        $this->table = $table;

        return $this;
    }

    public function clearTable()
    {
        $this->table = null;

        return $this;
    }

    /**
     * @return SQL\Set[]|null
     */
    public function getSet()
    {
        return $this->set;
    }

    /**
     * @param SQL\Set[] $set
     */
    public function setSet(array $set)
    {
        $this->set = $set;

        return $this;
    }

    public function clearSet()
    {
        $this->set = null;

        return $this;
    }

    /**
     * @param  string|SQL\SQL $table
     * @param  string         $alias
     * @return Update                $this
     */
    public function table($table, $alias = null)
    {
        $this->table []= new SQL\Aliased($table, $alias);

        return $this;
    }

    /**
     * @param  array $values
     * @return Update        $this
     */
    public function set(array $values)
    {
        foreach ($values as $column => $value) {
            $this->set []= new SQL\Set($column, $value);
        }

        return $this;
    }

    /**
     * @param array  $values
     * @param string $key
     * @return Update        $this
     */
    public function setMultiple(array $values, $key = 'id')
    {
        $values = Arr::flipNested($values);

        foreach ($values as $column => $changes) {
            $this->set []= new SQL\SetMultiple($column, $changes, $key);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function sql()
    {
        return Compiler\Update::render($this);
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return Compiler\Update::parameters($this);
    }
}
