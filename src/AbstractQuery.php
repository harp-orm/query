<?php

namespace Harp\Query;

use Harp\Query\Parametrised;
use Harp\Query\DB;
use Harp\Query\SQL;
use Harp\Query\Compiler\Compiler;

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

    /**
     * @param SQL\SQL $type
     */
    public function setType(SQL\SQL $type)
    {
        return $this->type = $type;
    }

    /**
     * @return AbstractQuery $this
     */
    public function clearType()
    {
        $this->type = null;

        return $this;
    }

    /**
     * @param  string|SQL\SQL $type
     * @return AbstractQuery $this
     */
    public function type($type)
    {
        $this->type = new SQL\SQL($type);

        return $this;
    }

    /**
     * @return DB
     */
    public function getDb()
    {
        if (! $this->db) {
            $this->db = DB::get();
        }

        return $this->db;
    }

    public function execute()
    {
        return $this->getDb()->execute($this->sql(), $this->getParameters());
    }

    /**
     * @return string
     */
    public function humanize()
    {
        return Compiler::humanize($this->sql(), $this->getParameters());
    }

    /**
     * @return string
     */
    abstract public function sql();
}
