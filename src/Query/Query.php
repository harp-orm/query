<?php namespace CL\Atlas\Query;

use CL\Atlas\Parametrised;
use CL\Atlas\Arr;
use CL\Atlas\DB;
use CL\Atlas\Compiler\Compiler;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
abstract class Query implements Parametrised {

    const TYPE     = 1;
    const TABLE    = 2;
    const FROM     = 3;
    const JOIN     = 4;
    const COLUMNS  = 5;
    const VALUES   = 6;
    const SELECT   = 7;
    const SET      = 8;
    const WHERE    = 9;
    const HAVING   = 10;
    const GROUP_BY = 11;
    const ORDER_BY = 12;
    const LIMIT    = 13;
    const OFFSET   = 14;

    protected $children;
    protected $db;

    public function __construct($children = NULL, DB $db = NULL)
    {
        $this->children = $children;
        $this->db = $db;
    }

    public function children($index = NULL)
    {
        if ($index === NULL)
        {
            return $this->children;
        }
        else
        {
            return isset($this->children[$index]) ? $this->children[$index] : NULL;
        }
    }

    public function parameters()
    {
        $parameters = array();

        if ($this->children)
        {
            $children = Arr::flatten($this->children);

            $parameters = array_map(function($child) {
                return ($child instanceof Parametrised) ? $child->parameters() : NULL;
            }, $children);

            $parameters = array_values(array_filter(Arr::flatten($parameters)));
        }

        return $parameters;
    }

    public function addChildren($name, $array)
    {
        if ($array)
        {
            $this->children[$name] = isset($this->children[$name]) ? array_merge($this->children[$name], $array) : $array;
        }
    }

    public function addChildrenObjects($name, $array, $argument, $callback)
    {
        $objects = Arr::toObjects($array, $argument, $callback);

        $this->addChildren($name, $objects);
    }

    public function db()
    {
        if ( ! $this->db)
        {
            $this->db = DB::instance();
        }

        return $this->db;
    }

    public function execute()
    {
        return $this->db()->execute($this->sql(), $this->parameters());
    }

    public function humanize()
    {
        return Compiler::humanize($this->sql(), $this->parameters());
    }

    abstract public function sql();
}
