<?php namespace Openbuildings\Cherry;

/**
 * Render SQL with "?" parameters
 * 
 * @package    Openbuildings\Cherry
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2013 OpenBuildings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class Compiler_Parametrized extends Compiler {

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

		return $this->compile($statement->column()).' '.$statement->operator().' '.$value;
	}

	public function statement_expression(Statement_Expression $statement)
	{
		return $statement->keyword();
	}

	public function statement_set(Statement_Set $statement)
	{
		if ($statement->value() instanceof Statement) 
		{
			$value = $this->compile_inner($statement->value());
		}
		else
		{
			$value = '?';
		}

		return $this->compile($statement->column()).' = '.$value;
	}

	public function statement_insert_values(Statement_Insert_Values $statement)
	{
		return '('.join(',', array_fill(0, count($statement->children()), '?')).')';
	}
}