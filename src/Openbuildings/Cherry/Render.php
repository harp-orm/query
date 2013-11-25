<?php
namespace Openbuildings\Cherry;

class Render {

	public function quote($content)
	{
		return (is_int($content) OR is_float($content)) ? $content : "\"{$content}\"";
	}

	public function render($statement)
	{
		if ($statement instanceof Query) 
		{
			return $this->query($statement);
		}
		else
		{
			$method = strtolower(substr(get_class($statement), 21));
			
			return $this->{$method}($statement);
		}
	}

	public function render_inner($statement)
	{
		$render = $this->render($statement);

		if ($statement instanceof Query 
			OR $statement instanceof Statement_Condition_Group) 
		{
			return "($render)";
		}

		return $render;
	}

	public function render_array(array $statement_array)
	{
		return array_map(array($this, 'render'), $statement_array);
	}

	public function statement_aliased(Statement_Aliased $statement)
	{
		return $this->render_inner($statement->statement()).' AS '.$statement->alias();
	}

	public function statement_column(Statement_Column $statement)
	{
		return $statement->name();
	}

	public function statement_condition_group(Statement_Condition_Group $statement)
	{
		$render = array();

		if ( ! $statement->parent())
		{
			$render []= $statement->keyword();
		}

		foreach ($statement->children() as $child_index => $child)
		{
			$render []= ($child_index > 0 ? $child->keyword().' ' : '').$this->render_inner($child);
		}

		return implode(' ', $render);
	}

	public function statement_condition(Statement_Condition $statement)
	{
		$value = $statement->value();

		if ($value instanceof Statement) 
		{
			$value = $this->render_inner($value);
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

		return $this->render($statement->column()).' '.$statement->operator().' '.$value;
	}

	public function statement_direction(Statement_Direction $statement)
	{
		$render = array($this->render($statement->column()));

		if ($statement->direction()) 
		{
			$render []= $statement->direction();
		} 

		return implode(' ', $render);
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
		$render = $statement->type() ? array($statement->type()) : array();

		$render []= $statement->keyword();
		$render []= $this->render($statement->table());

		if ($statement->using())
		{
			$render []= 'USING ('.join(', ', $this->render_array($statement->using())).')';
		}
		else
		{
			$render = array_merge($render, array(
				'ON',
				$this->render($statement->column()),
				$statement->operator(),
				$this->render($statement->foreign_column()),
			));
		}

		return implode(' ', $render);
	}

	public function statement_list(Statement_List $statement)
	{
		$render = array();

		if ($statement->keyword()) 
		{
			$render []= $statement->keyword();
		}

		$render	[]= implode(', ', $this->render_array($statement->children()));

		return implode(' ', $render);
	}

	public function statement_number(Statement_Number $statement)
	{
		return $statement->keyword().' '.$statement->number();
	}

	public function statement_set(Statement_Set $statement)
	{
		return $this->render($statement->column()).' = '.$this->quote($statement->value());
	}

	public function statement_table(Statement_Table $statement)
	{
		return $statement->name();
	}

	public function statement(Statement $statement)
	{
		$render = array();

		if ($statement->keyword()) 
		{
			$render []= $statement->keyword();
		}

		if ($statement->children())
		{
			$render	= array_merge($render, $this->render_array($statement->children()));
		}

		return implode(' ', $render);
	}

	public function query(Query $statement)
	{
		return $this->statement($statement);
	}
}