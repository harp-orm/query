<?php

namespace CL\Atlas\Compiler;

use CL\Atlas\Arr;
use CL\Atlas\Str;
use CL\Atlas\SQL;

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
     * @param  SQL\Condition[] $conditions
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

        if ($condition->getParameters() and array_filter($condition->getParameters(), 'is_array')) {
            $renderedParameters = array();

            foreach ($condition->getParameters() as $index => $value) {
                $renderedParameters[$index] = is_array($value) ? Compiler::toPlaceholders($value) : '?';
            }

            $content = Str::replace('/\?/', $renderedParameters, $content);
        }

        return $content;
    }
}
