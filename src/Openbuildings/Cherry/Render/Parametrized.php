<?php
namespace Openbuildings\Cherry;

class Render_Parametrized extends Render {

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
					$value = '('.join(', ', array_fill(0, count($value), '?')).')';
				break;

				case 'BETWEEN':
					$value = '? AND ?';
				break;
				
				default:
					$value = '?';
				break;
			}
		}

		return $this->render($statement->column()).' '.$statement->operator().' '.$value;
	}

	public function statement_expression(Statement_Expression $statement)
	{
		return $statement->keyword();
	}

}