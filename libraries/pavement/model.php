<?php 
defined('C5_EXECUTE') or die("Access Denied.");

class PavementModel extends ADOdb_Active_Record {

	public function __construct() {
	 	$db = Loader::db();
	 	parent::__construct();
	}
	
	/*
		Initializes an object with an existing one in the database.
	*/
	
	public function loadById($id, $idKey = 'id') {
		$this->load($idKey.' = ?', $id);
	}
	
	/*
		Returns an array of all objects in this table.
	*/
	
	public function all() {
		return $this->find('1=1');
	}
	
	/*
		Loop through an array and set each value to this object.
	*/
	
	public function setData($data) {
		foreach ($data as $key => $value) {
			if ($value == '') {
				$value = null;
			}
			$this->$key = $value;
		}
	}
	
	/*
		Optionally sets the data in the array,
		then calls replace() to insert/update the record.
	*/
	
	public function save($data = null) {
		if ($data != null) {
			$this->setData($data);
		}
		parent::replace();
	}
	
	/*
		Generates & returns a key => value array suitable for using in C5's 
		form helper select input function.
	*/
	
	public function getSelectOptions($idKey = 'id', $displayKey = 'name', $blankText = 'Choose an item...') {
		$items = array(null => $blankText);
		foreach ($this->all() as $item) {
			$items[$item->$idKey] = $item->$displayKey;
		}
		return $items;
	}
}

?>