<?php

namespace Harp\Query\SQL;

use Harp\Query\Arr;

/**
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class SetMultiple extends Set
{
    /**
     * @var string
     */
    private $key;

    /**
     * @param string $column
     * @param array  $values
     * @param string $key
     */
    public function __construct($column, array $values, $key = 'id')
    {
        $this->key = $key;

        parent::__construct($column, $values);
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getParameters()
    {
        return Arr::disassociate($this->getValue());
    }
}
