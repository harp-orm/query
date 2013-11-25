<?php
namespace Openbuildings\Cherry;

/**
 * Converts Query objects to SQL
 * 
 * @package    Openbuildings\Cherry
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2013 OpenBuildings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class Compiler {

	public function quote($content)
	{
		return (is_int($content) OR is_float($content)) ? $content : "\"{$content}\"";
	}

	public function compile($statement)
	{
		$method = strtolower(substr(get_class($statement), 21));
		
		return $this->{$method}($statement);
	}

	public function compile_inner($statement)
	{
		$text = $this->compile($statement);

		if ($statement instanceof Query 
			OR $statement instanceof Statement_Condition_Group) 
		{
			return "($text)";
		}

		return $text;
	}

	public function compile_array(array $statement_array)
	{
		return array_map(array($this, 'compile'), $statement_array);
	}

	public function statement_aliased(Statement_Aliased $statement)
	{
		return $this->compile_inner($statement->statement()).' AS '.$statement->alias();
	}

	public function statement_column(Statement_Column $statement)
	{
		return $statement->name();
	}

	public function statement_condition_group(Statement_Condition_Group $statement)
	{
		$text = array();

		if ( ! $statement->parent())
		{
			$text []= $statement->keyword();
		}

		foreach ($statement->children() as $child_index => $child)
		{
			$text []= ($child_index > 0 ? $child->keyword().' ' : '').$this->compile_inner($child);
		}

		return implode(' ', $text);
	}

	public function statement_condition(Statement_Condition $statement)
	{
		$value = $statement->value();

		if ($value instanceof Statement) 
		{
			$value = $this->compile_inner($value);
		}
		else
		{
			switch ($statement->operator())
			{
				case 'IN':
					$value = '('.join(', ', array_map(array($this, 'quote'), $value)).')';
				break;

				case 'BETWEEN':
					$value = $this->quote($value[0]).' AND '.$this->quote($value[1]);
				break;
				
				default:
					$value = $this->quote($value);
				break;
			}
		}

		return $this->compile($statement->column()).' '.$statement->operator().' '.$value;
	}

	public function statement_direction(Statement_Direction $statement)
	{
		$text = array($this->compile($statement->column()));

		if ($statement->direction()) 
		{
			$text []= $statement->direction();
		} 

		return implode(' ', $text);
	}

	public function statement_expression(Statement_Expression $statement)
	{
		if ($statement->parameters()) 
		{
			$parameters = array_map(array($this, 'quote'), $statement->parameters());

			$replace = function($matches) use ( & $parameters) {
				$current = current($parameters);
				next($parameters);
				return $current;
			};

			return preg_replace_callback('/\?/', $replace, $statement->keyword());
		}

		return $statement->keyword();
	}

	public function statement_join(Statement_Join $statement)
	{
		$text = $statement->type() ? array($statement->type()) : array();

		$text []= $statement->keyword();
		$text []= $this->compile($statement->table());

		if ($statement->using())
		{
			$text []= 'USING ('.join(', ', $this->compile_array($statement->using())).')';
		}
		else
		{
			$text = array_merge($text, array(
				'ON',
				$this->compile($statement->column()),
				$statement->operator(),
				$this->compile($statement->foreign_column()),
			));
		}

		return implode(' ', $text);
	}

	public function statement_list(Statement_List $statement)
	{
		$text = array();

		if ($statement->keyword()) 
		{
			$text []= $statement->keyword();
		}

		$text	[]= implode(', ', $this->compile_array($statement->children()));

		return implode(' ', $text);
	}

	public function statement_number(Statement_Number $statement)
	{
		return $statement->keyword().' '.$statement->number();
	}

	public function statement_set(Statement_Set $statement)
	{
		return $this->compile($statement->column()).' = '.$this->quote($statement->value());
	}

	public function statement_table(Statement_Table $statement)
	{
		return $statement->name();
	}

	public function statement(Statement $statement)
	{
		$text = array();

		if ($statement->keyword()) 
		{
			$text []= $statement->keyword();
		}

		if ($statement->children())
		{
			$text	= array_merge($text, $this->compile_array($statement->children()));
		}

		return implode(' ', $text);
	}

	public function query_select(Query $statement)
	{
		return $this->statement($statement);
	}

	public function query_update(Query $statement)
	{
		return $this->statement($statement);
	}

	public function query_delete(Query $statement)
	{
		return $this->statement($statement);
	}
}