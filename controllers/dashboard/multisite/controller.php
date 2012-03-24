<?php    
defined('C5_EXECUTE') or die(_("Access Denied."));
class DashboardMultisiteController extends Controller {
	
	public function on_start() {
		$this->redirect('/dashboard/multisite/sites/');
	}
	
}