<?php 
defined('C5_EXECUTE') or die("Access Denied.");

class Router {
	
	/* 
		Basic URL based routing and rewriting.
		This function gets called at the beginning of every
		request (during the on_start callback).
		
		Look at the URL, see if it's entered as a site,
		then route and rewrite the URL accordingly.
	*/
	public static function filter() {
		global $c;
		$request_path = $c->getCollectionPath();
		$hostname = RouteHelper::getHost();
		
		$pattern = '/(\\/sites\/'.$hostname.')(.*)/';
		$match = preg_match($pattern, $_SERVER['REQUEST_URI'], $matches);
		// var_dump($request_path);
		if(!$request_path) {
			$db = Loader::db();
			
			Loader::model('site', 'multisite');
			$site = new Site();
			$site->load('url LIKE ?', '%'.$hostname.'%');

			$homeId = $site->home_id;

			if(is_numeric($homeId)) {
				$home = Page::getByID($homeId);
		
				// append the child page path (if none, REQUEST_URI returns '/')
				$path = explode('?', $home->getCollectionPath().$_SERVER['REQUEST_URI']);
				$path = $path[0]; // don't include and URL parameters here
				$page = Page::getByPath($path);

				if ($page) {
					$c = $page; // assign the global $c
					
					$cpp = new Permissions($c);
					if ($cpp->isError() && $cpp->getError() == COLLECTION_FORBIDDEN) {
						// Do some forbidden stuff
						$v = View::getInstance();
						$v->setCollectionObject($c);
						$v->render('/login');
						exit;
					}
		
					// Set the current page
					$req = Request::get();
					$req->setCurrentPage($c);

					// Render the view
					$v = View::getInstance();
					$v->setCollectionObject($c);
					$v->render($c);
					exit;
				}
			}
		}
		elseif ($match) {
			$url = RouteHelper::getUrl($_SERVER['REQUEST_URI']);
			header('Location: http://'.$hostname.$url);
		}
	}
	
}