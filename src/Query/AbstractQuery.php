<?php

namespace CL\Atlas\Query;

use CL\Atlas\Parametrised;
use CL\Atlas\Arr;
use CL\Atlas\DB;
use CL\Atlas\Compiler\Compiler;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
abstract class AbstractQuery implements Parametrised
{
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

    /**
     * Child SQL objects
     * @var array
     */
    protected $children;

    /**
     * Link to a specific DB object
     * @var DB
     */
    protected $db;

    public function __construct($children = null, DB $db = null)
    {
        $this->children = $children;
        $this->db = $db;
    }

    /**
     * @return array|null
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param  string $name
     * @return CL\Atlas\SQL|null
     */
    public function getChild($name)
    {
        return isset($this->children[$name]) ? $this->children[$name] : null;
    }

    /**
     * Get all the parameters of all the child objects
     * @return array|null
     */
    public function getParameters()
    {
        $parameters = array();

        if ($this->children) {
            ksort($this->children);

            $children = Arr::flatten($this->children);

            foreach ($children as $child) {
                if ($child instanceof Parametrised AND (($childParams = $child->getParameters()) !== null)) {
                    $parameters []= $childParams;
                }
            }

            $parameters = array_values(Arr::flatten($parameters));
        }

        return $parameters;
    }

    /**
     * Add children of a type, do not overwrite existing
     * @param string $name
     * @param array  $array
     */
    public function addChildren($name, $array)
    {
        if ($array) {
            // $array = Arr::toArray($array);

            if (isset($this->children[$name])) {
                $this->children[$name] = array_merge($this->children[$name], $array);
            } else {
                $this->children[$name] = $array;
            }
        }
    }

    public function db()
    {
        if (! $this->db) {
            $this->db = DB::instance();
        }

        return $this->db;
    }

    public function execute()
    {
        return $this->db()->execute($this->sql(), $this->getParameters());
    }

    public function humanize()
    {
        return Compiler::humanize($this->sql(), $this->getParameters());
    }

    abstract public function sql();
}
