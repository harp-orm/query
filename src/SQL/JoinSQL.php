<?php namespace CL\Atlas\SQL;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class JoinSQL extends SQL
{
    protected $table;
    protected $condition;
    protected $type;

    function __construct($table, $condition, $type = null)
    {
        if (is_array($condition)) {
            $statements = array();

            foreach ($condition as $column => $foreign_column) {
                $statements [] = "$column = $foreign_column";
            }

            $this->condition = 'ON '.join(' AND ', $statements);
        } else {
            $this->condition = $condition;
        }

        $this->type = $type;

        if (is_array($table)) {
            $this->table = new AliasedSQL(key($table), reset($table));
        } elseif ($table instanceof SQL) {
            $this->table = $table;
        } else {
            $this->table = new AliasedSQL($table);
        }
    }

    public function table()
    {
        return $this->table;
    }

    public function condition()
    {
        return $this->condition;
    }

    public function parameters()
    {
        if ($this->condition instanceof SQL) {
            return $this->condition->parameters();
        }

        return parent::parameters();
    }

    public function type()
    {
        return $this->type;
    }
}
