<?php 

defined('C5_EXECUTE') or die("Access Denied.");
Loader::library('pavement/model', 'multisite');

class MultisiteDomain extends PavementModel {
	var $_table = 'MultisiteDomains';
	var $errors = array();
	
	public function getFields() {
		return array(
			'url' => array(
				'label' => t('URL'),
				'type' => 'text',
				'required' => true
			),
			'home_id' => array(
				'label' => t('Home Page'),
				'type' => 'page',
				'required' => true
			),
			'favicon' => array(
				'label' => t('Favicon'),
				'type' => 'file',
				'required' => false
			)
		);
	}
	
	public function create($data) {
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
				$val->addRequired($key, $field['label'].t(' is required.'));
			}
		}
		
		$val->setData($data);
		$test = $val->test();
		
		if ($data['url']) {
			if ($this->exists($data['url'])) {
				$this->errors[] = t('A site with that URL already exists.');
			}
		}

		if (!$test) {
			$this->errors = array_merge($this->errors, $val->getError()->getList());
		}

		return $val->test();
	}
	
	public function exists($url) {
		$url = MsRouteHelper::sanitizeUrl($url);
		$sites = array();
		foreach ($this->all() as $site) {
			$sites[] = $site->url;
		}
		return in_array($url, $sites);
	}
	
	public function getPage() {
		return Page::getByID($this->home_id);
	}
	
}