<?php    
defined('C5_EXECUTE') or die(_("Access Denied."));
class DashboardMultisiteSitesController extends Controller {
	
	public function on_start() {
		Loader::model('site', 'multisite');
	}
	
	public function view() {
		$this->getFields();
		$this->getSites();
		$this->set('prettyUrls', URL_REWRITING);
	}
	
	private function getFields() {
		$site = new Site();
		$this->set('fields', $site->getFields());
	}
	
	private function getSites() {
		$site = new Site();
		$this->set('sites', $site->all());
	}
	
	public function saveData() {
		$site = new Site();
		if ($site->create($_POST)) {
			$this->redirect('/dashboard/multisite/sites');	
		}
		else {
			$this->set('errors', $site->errors);
			$this->view();
		}
	}
	
	public function delete($id) {
		$site = new Site();
		$site->loadById($id);
		$site->delete();
		$this->redirect('/dashboard/multisite/sites');
	}
	
}