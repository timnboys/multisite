<?php 
defined('C5_EXECUTE') or die("Access Denied.");

class Router {
	
	/* 
		Basic URL based routing and rewriting.
		This function gets called at the beginning of every
		request (during the on_start callback).
		
		Look at the URL, see if it's entered as a site,
		then route and rewrite the URL accordingly.
		
		Here's the flow:
		Because this gets run before the rendering, it actually can get called twice.
		This needs to be fixed.
		Request comes in to home page, request_path is null
		Request 
	*/

	public static function render() {
		if (!isset($_SESSION['routing'])) {
			global $c;

			Loader::model('site', 'multisite');
			$site = new Site();

			$hostname = RouteHelper::getHost();

			$request_path = ($c) ? $c->getCollectionPath() : '';

			// Only filter URLs that exist as sites
			if ($site->exists($hostname)) {
				$site->load('url LIKE ?', '%'.$hostname.'%');
				$homePage = Page::getByID($site->home_id);

				if (!$request_path) {
					$c = $homePage;
				}
				else {
					$request_path = $homePage->getCollectionPath().$request_path;
					$c = Page::getByPath($request_path);
				}
				self::renderPage($c);
			}			
		}
		else {
			unset($_SESSION['routing']);
		}
	}
	
	private function renderPage($page) {
		$_SESSION['routing'] = true;
		
		$perm = new Permissions($c);
		if ($perm->isError()) {
			if ($perm->getError() == COLLECTION_FORBIDDEN) {
				// User is not authorized for this page
				$v = View::getInstance();
				$v->setCollectionObject($page);
				$v->render('/login');
				exit;	
			}
		}
		
		// Set the current page
		$req = Request::get();
		$req->setCurrentPage($page);

		// Render the view
		$v = View::getInstance();
		$v->setCollectionObject($page);
		$v->render($page);
		exit;
	}
	
}