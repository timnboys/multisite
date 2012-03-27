<?php 
defined('C5_EXECUTE') or die("Access Denied.");

class Router {
	
	/* 
		Basic URL based routing and rewriting.
		This function gets called at the beginning of every
		request (during the on_before_render callback).
		
		Look at the URL, see if it's entered as a site,
		then route and rewrite the URL accordingly.
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
					// Need a little logic to make sure we don't render 404s
					$path = explode('?', $homePage->getCollectionPath().$_SERVER['REQUEST_URI']);
					$path = $path[0]; // don't include any URL parameters here
					if ($path == $homePage->getCollectionPath().'/') {
						// render the home page
						$c = $homePage;	
						self::renderPage($c, $site);
					}
				}
				else {
					$request_path = $homePage->getCollectionPath().$request_path;
					$c = Page::getByPath($request_path);
					if (!$c->getCollectionID()) {
						// force a 404
						header('HTTP/1.0 404 Not Found');
						$c = Page::getByPath('/page_not_found');
					}
					self::renderPage($c, $site);
				}
			}			
		}
		else {
			unset($_SESSION['routing']);
		}
	}
	
	private function renderPage($page, $site) {
		// set a session variable to prevent infinite rendering
		$_SESSION['routing'] = true;
		
		$perm = new Permissions($page);
		if (!$perm->isError()) {
			// Set the current page in the request object
			Request::get()->setCurrentPage($page);

			// Render the view
			$view = View::getInstance();
			$view->setCollectionObject($page);
			
			if ($site->favicon) {
				$favicon = File::getByID($site->favicon);
				$view->addHeaderItem('<link rel="icon" href="'.$favicon->getRelativePath().'" type="image/x-icon" />');
				$view->addHeaderItem('<link rel="shortcut icon" href="'.$favicon->getRelativePath().'" type="image/x-icon" />');
			}
			
			$view->render($page);
			exit;			
		}
		
	}
	
}