<?php

require_once dirname(__FILE__) . '/../vendor/MobileDetect/Mobile_Detect.php';

class MobileRedirect {
	public static function redirectIfMobile() {
		$detect = new Mobile_Detect();
		if ($detect->isMobile() && !isset($_COOKIE['viewDesktopSite'])) {
			header('Location: /mobile/');
		}
	}
}













