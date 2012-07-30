<?php

class LinkDAO extends Model_array {
	public function __construct () {
		parent::__construct (PUBLIC_PATH . '/data/links');
	}
	
	public function addLink ($values) {
		$id = $this->generateKey ($type);
		$this->array[$id] = array ();
		
		foreach ($values as $key => $value) {
			$this->array[$id][$key] = $value;
		}
		
		$this->writeFile($this->array);
	}
	
	public function updateLink ($id, $values) {
		foreach ($values as $key => $value) {
			$this->array[$id][$key] = $value;
		}
		
		$this->writeFile($this->array);
	}
	
	public function deleteLink ($id) {
		unset ($this->array[$id]);
		$this->writeFile($this->array);
	}
	
	public function listLinks () {
		$list = $this->array;
		
		if (!is_array ($list)) {
			$list = array ();
		}
		
		return HelperLink::listeDaoToLink ($list);
	}
	
	public function searchLink ($id) {
		$link = $this->array[$id];
		return HelperLink::daoToLink ($link);
	}
	
	private function generateKey () {
		for ($i = 0; $i <= count ($this->array); $i++) {
			if (!isset ($this->array[$i])) {
				return $i;
			}
		}
		
		return time ();
	}
}
