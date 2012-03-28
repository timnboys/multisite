<?php
defined('C5_EXECUTE') or die(_("Access Denied."));

class MultisitePackage extends Package {

	protected $pkgDescription = 'Manage multiple websites with ease.';
	protected $pkgName = 'Multisite Pro';
	protected $pkgHandle = 'multisite';

	protected $appVersionRequired = '5.5.0.0';
	protected $pkgVersion = '0.9.1';

	public function on_start() {
		Loader::helper('ms_route', 'multisite');
		if (!User::isLoggedIn() ) {
			Events::extend('on_before_render',
				'MsRouter',
				'render',
				'packages/'.$this->pkgHandle.'/models/ms_router.php'
			);
		}
	}

	public function install() {
		$pkg = parent::install();
		Loader::model('single_page');
		$main = SinglePage::add('/dashboard/multisite', $pkg);
		$mainSites = SinglePage::add('/dashboard/multisite/sites', $pkg);
	}

}