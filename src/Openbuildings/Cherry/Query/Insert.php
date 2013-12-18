<?php
namespace Openbuildings\Cherry;

/**
 * INSERT Query
 * 
 * @package    Openbuildings\Cherry
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2013 OpenBuildings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class Query_Insert extends Query {

	protected static $children_names = array(
		'PREFIX',
		'INTO',
		'COLUMNS',
		'SET',
		'SELECT',
		'VALUES',
	);

	protected $keyword = 'INSERT';

	public function prefix($prefix)
	{
		$this->children['PREFIX'] = new Statement($prefix);

		return $this;
	}

	public function into($table)
	{
		$this->children['INTO'] = new Statement('INTO', array(Query::new_table($table)));

		return $this;
	}

	public function columns($columns)
	{
		$columns = func_get_args();

		$column_statements = array_map('Openbuildings\Cherry\Query::new_column', $columns);

		if ( ! isset($this->children['COLUMNS'])) 
		{
			$this->children['COLUMNS'] = new Statement_Insert_Columns(NULL);
		}

		$this->children['COLUMNS']->append($column_statements);

		return $this;
	}

	/**
	 * Choose the columns to select from.
	 *
	 * @param   mixed  $columns  column name or array($column, $alias) or object
	 * @return  $this
	 */
	public function set(array $pairs)
	{
		$sets = array();

		foreach ($pairs as $column => $value) 
		{
			$sets []= Query::new_set($column, $value);
		}

		$this->set_list('SET', $sets);

		return $this;
	}

	public function select(Query $select)
	{
		$this->children['SELECT'] = $select;
	}

	public function values(array $values)
	{
		$value_sets = func_get_args();

		$value_statements = array_map('Openbuildings\Cherry\Query::new_insert_values', $value_sets);

		$this->set_list('VALUES', $value_statements);

		return $this;
	}
}