<?php
namespace Openbuildings\Cherry;

/**
 * DELETE Query
 * 
 * @package    Openbuildings\Cherry
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2013 OpenBuildings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class Query_Delete extends Query_Where {

	protected static $children_names = array(
		'ONLY',
		'FROM',
		'WHERE',
		'LIMIT',
	);

	protected $keyword = 'DELETE';

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