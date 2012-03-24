<?php 

defined('C5_EXECUTE') or die("Access Denied.");
Loader::library('pavement/model', 'multisite');

class Site extends PavementModel {
	
	public function create($data) {
		$page = $this->createPage('/sites', $data['page_type'], $data['title'], $data['title']);
		$url = str_replace(array('http://','https://', 'www.'), '', $data['url']);
		if (is_object($page)) {
			$this->save(array(
				'url' => $url,
				'home_id' => $page->getCollectionID()
			));	
		}
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