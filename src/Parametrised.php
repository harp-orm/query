<?php

namespace Harp\Query;

/**
 * This interface is used to enforce a common methods between SQL and Query classes
 *
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
interface Parametrised
{
    public function getParameters();
}
