<?php namespace CL\Atlas\Compiler;

use CL\Atlas\Arr;
use CL\Atlas\Str;
use CL\Atlas\SQL\ConditionSQL;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class ConditionCompiler extends Compiler
{
    public static function combine($conditions)
    {
        return Arr::join(' AND ', Arr::map(function($condition) {
            return "(".ConditionCompiler::render($condition).")";
        }, $conditions));
    }

    public static function render(ConditionSQL $condition)
    {
        $content = $condition->content();

        if ($condition->parameters() AND array_filter($condition->parameters(), 'is_array')) {
            $rendered_parameters = array();

            foreach ($condition->parameters() as $index => $value) {
                $rendered_parameters[$index] = is_array($value) ? Compiler::toPlaceholders($value) : '?';
            }

            $content = Str::replace('/\?/', $rendered_parameters, $content);
        }

        return $content;
    }
}
