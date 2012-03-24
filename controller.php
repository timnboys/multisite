<?php
defined('C5_EXECUTE') or die(_("Access Denied."));

class MultisitePackage extends Package {

	protected $pkgDescription = 'Manage multiple websites with ease.';
	protected $pkgName = 'Multisite Pro';
	protected $pkgHandle = 'multisite';

	protected $appVersionRequired = '5.4.0.0';
	protected $pkgVersion = '1.0';

	public function on_start() {
		Events::extend('on_start',
			'Router',
			'filter',
			'packages/'.$this->pkgHandle.'/models/router.php'
		);
	}

	public function install() {
		$pkg = parent::install();
		Loader::model('single_page');
		$main = SinglePage::add('/dashboard/multisite', $pkg);
		$mainSites = SinglePage::add('/dashboard/multisite/sites', $pkg);
		$sitesController = SinglePage::add('/sites', $pkg);
		$sitesController->setAttribute('exclude_nav', 1);
		self::runSql('install');
	}
	
	private function runSql($file) {
		$path = getcwd().'/packages/'.$this->pkgHandle.'/sql/'.$file.'.sql';
		$sql = file_get_contents($path);
		$db = Loader::db();
		foreach (explode(";\n", $sql) as $line) {
			if ($line) {
				$db->execute($line);
			}
		}
	}
	
	public function upgrade(){
		self::runSql('upgrade');
		return parent::upgrade();
	}
	
	public function uninstall() {
		self::runSql('uninstall');
		parent::uninstall();
	}

}