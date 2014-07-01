<?php

namespace Harp\Query\SQL;

/**
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class Condition extends SQL
{
    /**
     * @var string
     */
    private $column;

    /**
     * @param string $column
     * @param string $content
     * @param array $parameters
     */
    public function __construct($column, $content, array $parameters = array())
    {
        $this->column = $column;

        parent::__construct($content, $parameters);
    }

    /**
     * @return string
     */
    public function getColumn()
    {
        return $this->column;
    }
}
