<?php namespace CL\Atlas\Compiler;

use CL\Atlas\Arr;
use CL\Atlas\Query\Query;
use CL\Atlas\Query\DeleteQuery;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class DeleteCompiler extends Compiler
{
    public static function render(DeleteQuery $query)
    {
        return Compiler::expression(array(
            'DELETE',
            $query->children(Query::TYPE),
            Arr::join(', ', $query->children(Query::TABLE)),
            Compiler::word(
                'FROM',
                AliasedCompiler::combine($query->children(Query::FROM))
            ),
            JoinCompiler::combine(
                $query->children(Query::JOIN)
            ),
            Compiler::word(
                'WHERE',
                ConditionCompiler::combine(
                    $query->children(Query::WHERE)
                )
            ),
            Compiler::word(
                'ORDER BY',
                DirectionCompiler::combine(
                    $query->children(Query::ORDER_BY)
                )
            ),
            Compiler::word(
                'LIMIT',
                $query->children(Query::LIMIT)
            ),
        ));
    }
}
