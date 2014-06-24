<?php

namespace Harp\Query;

/**
 * This interface is used to enforce a common methods between SQL and Query classes
 *
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
interface Parametrised
{
    public function getParameters();
}
