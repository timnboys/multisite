<?php    
/* 
	All code copyright 2012 David Strack.
	Web: http://dave.li
	Email: davidstrack@icloud.com
	Twitter: @rmxdave
*/
defined('C5_EXECUTE') or die(_("Access Denied."));
class DashboardMultisiteController extends Controller {
	
	public function on_start() {
		$this->redirect('/dashboard/multisite/sites/');
	}
	
}