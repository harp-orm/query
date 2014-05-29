<?php

namespace Luna\Query\Compiler;

use Luna\Query\Arr;
use Luna\Query\SQL;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Condition
{
    /**
     * Render multiple Condition objects
     *
     * @param  SQL\Condition[]|null $conditions
     * @return string|null
     */
    public static function combine($conditions)
    {
        return Arr::join(' AND ', Arr::map(function ($condition) {
            return "(".Condition::render($condition).")";
        }, $conditions));
    }

    /**
     * Render a Condition object
     *
     * @param  SQL\Condition $condition
     * @return string
     */
    public static function render(SQL\Condition $condition)
    {
        $content = $condition->getContent();
        $parameters = $condition->getParameters();

        if ($parameters) {
            $content = self::expandParameterArrays($content, $parameters);
        }

        return $content;
    }

    /**
     * Replace ? for arrays with (?, ?, ?)
     *
     * @param  string $content
     * @param  array  $parameters
     * @return string
     */
    public static function expandParameterArrays($content, array $parameters)
    {
        return preg_replace_callback('/\?/', function () use (& $parameters) {
            $parameter = current(each($parameters));
            return is_array($parameter) ? Compiler::toPlaceholders($parameter) : '?';
        }, $content);

    }
}
