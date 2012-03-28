<?php
defined('C5_EXECUTE') or die(_("Access Denied."));

class RouteHelper {
		
	public static function getHost() {
		return self::sanitizeUrl($_SERVER['HTTP_HOST']);
	}
	
	public static function sanitizeUrl($url) {
		return strtolower(str_replace('www.', '', $url));
	}
	
}