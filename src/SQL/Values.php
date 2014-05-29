<?php

namespace Harp\Query\SQL;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Values extends SQL
{
    public function __construct(array $values)
    {
        parent::__construct(null, $values);
    }
}
