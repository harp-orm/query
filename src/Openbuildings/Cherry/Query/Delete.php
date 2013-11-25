<?php
namespace Openbuildings\Cherry;

class Query_Delete extends Query_Where {

	protected static $children_names = array(
		'ONLY',
		'FROM',
		'WHERE',
		'LIMIT',
	);

	protected $current_having;

	public function __construct($tables = NULL)
	{
		parent::__construct('DELETE');

		$tables = func_get_args();

		if ($tables) 
		{
			call_user_func(array($this, 'from'), $tables);
		}
	}

	public function only($tables)
	{
		$tables = func_get_args();

		$table_statements = array_map('Openbuildings\Cherry\Query::new_table', $tables);

		$this->set_list('ONLY', $table_statements, NULL, FALSE);

		return $this;
	}

	public function from($tables)
	{
		$tables = func_get_args();

		$table_statements = array_map('Openbuildings\Cherry\Query::new_aliased_table', $tables);

		$this->set_list('FROM', $table_statements);

		return $this;
	}


}