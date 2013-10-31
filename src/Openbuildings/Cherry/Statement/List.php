<?php
namespace Openbuildings\Cherry;

class Statement_List extends Statment {

	public function compile()
	{
		$compiled_array = array_map(function($item) { 
			return $item->compile(); 
		}, $this->children);

		return implode(', ', $compiled_array);
	}
}