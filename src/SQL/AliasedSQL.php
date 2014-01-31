<?php namespace CL\Atlas\SQL;

use CL\Atlas\Parametrised;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class AliasedSQL extends SQL
{
    protected $alias;

    public static function factory($content, $alias = null)
    {
        return new AliasedSQL($content, $alias);
    }

    function __construct($content, $alias = null)
    {
        $this->content = $content;
        $this->alias = $alias;
    }

    public function parameters()
    {
        if ($this->content() instanceof Parametrised) {
            return $this->content()->parameters();
        }
    }

    public function alias()
    {
        return $this->alias;
    }
}
