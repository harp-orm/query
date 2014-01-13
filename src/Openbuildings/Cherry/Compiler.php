<?php namespace Openbuildings\Cherry;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Compiler
{
	protected function joins($content)
	{
		if ($content) 
		{
			return self::expression(array_map(function(SQL_Join $join) {
				return self::expression(array(
					$join->type(),
					'JOIN', 
					$join->table(),
					$join->condition()
				));
			}, $content));
		}
	}

	public static function to_placeholders(array $array)
	{
		return '('.join(', ', array_pad('?', count($array))).')';
	}

	protected static function expression(array $parts)
	{
		return implode(' ', array_filter($parts));
	}

	protected static function set($content)
	{
		return $content ? join(', ', $content) : NULL;
	}

	protected static function word($statement, $content)
	{
		return $content ? $statement.' '.$content : NULL;
	}

	protected static function brace($content)
	{
		if (is_array($content) AND count($content) > 1) 
		{
			$content = array_map(function($item) { return "($item)"; }, $content);
		}
		return $content;
	}

	public function aliased_set($content, $default = NULL)
	{
		return $content ? self::set(array_map(array($this, 'aliased'), $content)) : $default;
	}

	public function conditions_set($content)
	{
		return $content ? join(' AND ', self::brace(array_map(array($this, 'condition'), $content))) : NULL;
	}

	protected function condition($item)
	{
		$content = $item->content();
		if ($item->parameters() == array(10, 20, array('1', '2', '3'))) 
		{
			var_dump($item->parameters());
				die('asdads');
		}
		if ($item->parameters() AND Arr::has_array($item->parameters())) 
		{
			$params = $item->parameters();
			$i=0;
			$content = preg_replace_callback('/\?/', function($matches) use ($params, & $i) {
				$param = $params[$i++];
				return is_array($param) ? self::to_placeholders($param) : '?';
			}, $content);
		}

		return $content;
	}

	protected function aliased($item)
	{
		$content = $item->content();

		if ($content instanceof Query_Select) 
		{
			$content = "(".$this->render($content).")";
		}

		return self::expression(array(
			$content,
			self::word('AS', $item->alias())
		));
	}


}
