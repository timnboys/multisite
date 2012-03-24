<?php    
defined('C5_EXECUTE') or die(_("Access Denied."));
class DashboardMultisiteSitesController extends Controller {
	
	public function view() {
		$this->getPageTypes();
		$this->getSites();

		$this->set('prettyUrls', URL_REWRITING);
	}
	
	private function getSites() {
		Loader::model('site', 'multisite');
		$site = new Site();
		$this->set('sites', $site->all());
	}
	
	private function getPageTypes() {
		$db = Loader::db();
		$sql = "SELECT * FROM PageTypes WHERE ctIsInternal = 0";
		$results = $db->GetAll($sql);
		$pageTypes = array(null => 'Choose a page type...');
		foreach ($results as $r) {
			$pageTypes[$r['ctHandle']] = $r['ctName'];
		}
		$this->set('pageTypes', $pageTypes);
	}
	
	public function saveData() {
		Loader::model('site', 'multisite');
		$site = new Site();
		$site->create($_POST);
		$this->redirect('/dashboard/multisite/sites');
	}
	
	public function delete($id) {
		Loader::model('site', 'multisite');
		$site = new Site();
		$site->loadById($id);
		$site->delete();
		$this->redirect('/dashboard/multisite/sites');
	}
	
}