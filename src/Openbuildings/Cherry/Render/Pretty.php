<?php
namespace Openbuildings\Cherry;

class Render_Pretty extends Render {

	public function query(Query $statement)
	{
		$render = array($statement->keyword());

		if ($statement->children())
		{
			$render	= array_merge($render, $this->render_array($statement->children()));
		}

		return implode("\n", $render);
	}
}