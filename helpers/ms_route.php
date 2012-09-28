<?php
/* 
	All code copyright 2012 David Strack.
	Web: http://dave.li
	Email: davidstrack@icloud.com
	Twitter: @rmxdave
*/
defined('C5_EXECUTE') or die(_("Access Denied."));

class MsRouteHelper {
		
	public static function getHost() {
		return self::sanitizeUrl($_SERVER['HTTP_HOST']);
	}
	
	public static function sanitizeUrl($url) {
		return strtolower(str_replace('www.', '', $url));
	}
	
}