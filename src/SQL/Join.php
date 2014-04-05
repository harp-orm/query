<?php namespace CL\Atlas\SQL;

use CL\Atlas\Parametrised;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Join extends SQL
{
    protected $table;
    protected $condition;
    protected $type;

    public static function arrayToCondition(array $condition)
    {
        $statements = array();

        foreach ($condition as $column => $foreign_column) {
            $statements [] = "$column = $foreign_column";
        }

        return 'ON '.join(' AND ', $statements);
    }

    public function __construct(SQL $table, $condition, $type = null)
    {
        $this->condition = is_array($condition)
            ? self::arrayToCondition($condition)
            : $condition;

        $this->type = $type;

        $this->table = $table;
    }

    public function getTable()
    {
        return $this->table;
    }

    public function getCondition()
    {
        return $this->condition;
    }

    public function getParameters()
    {
        if ($this->condition instanceof Parametrised) {
            return $this->condition->getParameters();
        }

        return parent::getParameters();
    }

    public function getType()
    {
        return $this->type;
    }
}
