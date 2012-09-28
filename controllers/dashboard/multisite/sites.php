<?php    
/* 
	All code copyright 2012 David Strack.
	Web: http://dave.li
	Email: davidstrack@icloud.com
	Twitter: @rmxdave
*/
defined('C5_EXECUTE') or die(_("Access Denied."));
class DashboardMultisiteSitesController extends Controller {
	
	public function on_start() {
		Loader::model('multisite_domain', 'multisite');
	}
	
	public function view() {
		$this->getFields();
		$this->getSites();
		$this->set('prettyUrls', URL_REWRITING);
	}
	
	public function edit($id) {
		$site = new MultiSiteDomain();
		$site->loadById($id);
		$this->set('data', (array) $site);
		$this->view();
	}
	
	private function getFields() {
		$site = new MultiSiteDomain();
		$this->set('fields', $site->getFields());
	}
	
	private function getSites() {
		$site = new MultiSiteDomain();
		$this->set('sites', $site->all());
	}
	
	public function saveData() {
		$site = new MultiSiteDomain();
		if ($site->create($_POST)) {
			$this->redirect('/dashboard/multisite/sites');	
		}
		else {
			$this->set('errors', $site->errors);
			$this->view();
		}
	}
	
	public function delete($id) {
		$site = new MultiSiteDomain();
		$site->loadById($id);
		$site->delete();
		$this->redirect('/dashboard/multisite/sites');
	}
	
}