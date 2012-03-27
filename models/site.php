<?php 

defined('C5_EXECUTE') or die("Access Denied.");
Loader::library('pavement/model', 'multisite');

class Site extends PavementModel {
	
	var $errors = array();
	
	public function getFields() {
		return array(
			'url' => array(
				'label' => 'URL',
				'type' => 'text',
				'required' => true
			),
			'home_id' => array(
				'label' => 'Home Page',
				'type' => 'page',
				'required' => true
			),
			'favicon' => array(
				'label' => 'Favicon',
				'type' => 'file',
				'required' => false
			)
		);
	}
	
	public function create($data) {
		// d($data);
		if ($this->validate($data)) {
			$url = str_replace(array('http://','https://', 'www.'), '', $data['url']);

			if ($data['id']) {
				$this->loadById($data['id']);
			}

			$this->save(array(
				'url' => $url,
				'home_id' => $data['home_id'],
				'favicon' => $data['favicon']
			));	
			return true;
		}
		else {
			return false;
		}
	}
	
	private function validate($data) {
		$val = Loader::helper('validation/form');
		
		foreach ($this->getFields() as $key => $field) {
			if ($field['type'] == 'page' && $data[$key] == 0) {
				$data[$key] = null;
			}
			if ($field['required']) {
				$val->addRequired($key, $field['label'].' is required.');
			}
		}
		
		$val->setData($data);
		$test = $val->test();
		
		if ($data['url']) {
			if ($this->exists($data['url'])) {
				$this->errors[] = 'A site with that URL already exists.';
			}
		}

		if (!$test) {
			$this->errors = array_merge($this->errors, $val->getError()->getList());
		}

		return $val->test();
	}
	
	public function exists($url) {
		$url = RouteHelper::sanitizeUrl($url);
		$sites = array();
		foreach ($this->all() as $site) {
			$sites[] = $site->url;
		}
		return in_array($url, $sites);
	}
	
	private function createPage($path, $pageType, $name, $handle) {
		$pt = CollectionType::getByHandle($pageType);

		$parent = Page::getByPath($path, $version = 'RECENT');
		$data = array('cName' => $name, 'cHandle' => $handle);
		$p = $parent->add($pt, $data);
		return $p;		
	}
	
	public function getPage() {
		return Page::getByID($this->home_id);
	}
	
}