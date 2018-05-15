<?php
/**
 * Kenshimdev : Développeur web et administrateur système (https://kenshimdev.fr/)
 * @author        Kenshimdev - https://kenshimdev.fr
 * @copyright     Kenshimdev - All rights reserved
 * @link          http://mineweb.org/market
 * @since         23.01.2017
 */

class SSLChecker {

	/**
	 * Checks that the request is https
	 */
	public function isRequestHttps(){
		return ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) ? true : false;
	}

	/**
	 * Verifies that a URL is in HTTPS
	 * @param $url type string - the url to test
	 */
	public function isUrlHttps($url){
		$url = parse_url($url);
		return ($url['scheme'] == 'https') ? true : false;
	}

}