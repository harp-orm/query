<?php

namespace CL\Atlas\Query;

use CL\Atlas\Parametrised;
use CL\Atlas\DB;
use CL\Atlas\SQL;
use CL\Atlas\Compiler\Compiler;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
abstract class AbstractQuery implements Parametrised
{
   /**
     * Link to a specific DB object
     * @var DB
     */
    protected $db;

    /**
     * @var SQL\SQL|null
     */
    protected $type;

    public function __construct(DB $db = null)
    {
        $this->db = $db;
    }

    /**
     * @return SQL\SQL
     */
    public function getType()
    {
        return $this->type;
    }

    public function db()
    {
        if (! $this->db) {
            $this->db = DB::instance();
        }

        return $this->db;
    }

    public function type($type)
    {
        $this->type = new SQL\SQL($type);

        return $this;
    }

    public function execute()
    {
        return $this->db()->execute($this->sql(), $this->getParameters());
    }

    public function humanize()
    {
        return Compiler::humanize($this->sql(), $this->getParameters());
    }

    /**
     * @return string
     */
    abstract public function sql();
}
