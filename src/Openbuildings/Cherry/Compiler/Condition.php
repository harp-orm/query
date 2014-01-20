<?php namespace Openbuildings\Cherry;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Compiler_Condition extends Compiler
{
	public static function combine($conditions)
	{
		return Arr::join(' AND ', Arr::map(function($condition) {
			return "(".Compiler_Condition::render($condition).")";
		}, $conditions));
	}

	public static function render(SQL_Condition $condition)
	{
		$content = $condition->content();

		if ($condition->parameters() AND array_filter($condition->parameters(), 'is_array')) 
		{
			$rendered_parameters = array();

			foreach ($condition->parameters() as $index => $value)
			{
				$rendered_parameters[$index] = is_array($value) ? Compiler::to_placeholders($value) : '?';
			}

			$content = Str::replace('/\?/', $rendered_parameters, $content);
		}

		return $content;
	}
}
