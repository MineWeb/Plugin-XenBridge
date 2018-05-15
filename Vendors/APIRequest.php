<?php
/**
 * Kenshimdev : Développeur web et administrateur système (https://kenshimdev.fr/)
 * @author        Kenshimdev - https://kenshimdev.fr
 * @copyright     Kenshimdev - All rights reserved
 * @link          http://mineweb.org/market
 * @since         23.01.2017
 */

class APIRequest {
    private $userAgent;
    private $timeout;

    public function __construct($userAgent, $timeout) {
        $this->userAgent = $userAgent;
        $this->timeout = $timeout;
    }

   /**
    * Makes a request to the requested URL
    * @param $url - The url to request
    */
    public function exec($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE); 
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0); 
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->userAgent);
        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
        if (curl_errno($ch) || $info['http_code'] != 200) {
          curl_close($ch);
          //throw new Exception("Unable to perform this query !");
          //throw new Exception($result, $info['http_code']);
          return $result;
        } else {
          curl_close($ch);
          return $result;
        }
    }

}