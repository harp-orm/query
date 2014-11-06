<?php

namespace Harp\Query\Test;

use Harp\Query\SelectExtensionTrait;

/**
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class SelectExtension
{
    use SelectExtensionTrait;

    private $select;

    public function getSelect()
    {
        return $this->select;
    }

    public function __construct($select)
    {
        $this->select = $select;
    }
}
