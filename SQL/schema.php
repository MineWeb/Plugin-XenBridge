<?php
/**
 * Kenshimdev : Développeur web et administrateur système (https://kenshimdev.fr/)
 * @author        Kenshimdev - https://kenshimdev.fr
 * @copyright     Kenshimdev - All rights reserved
 * @link          http://mineweb.org/market
 * @since         23.01.2017
 */
 
class XenbridgeAppSchema extends CakeSchema {

	public function before($event = []) {
		return true;
	}

	public function after($event = []) {}

	public $xenbridge__configurations = [
		'id' => [
			'type' => 'integer',
			'null' => false,
			'default' => null,
			'length' => 10,
			'unsigned' => false,
			'autoIncrement' => true,
			'key' => 'primary'],
			
		'xenapi_key' => [
			'type' => 'string',
			'null' => false,
			'default' => null,
			'length' => 50],

		'xenapi_fullpath' => [
			'type' => 'string',
			'null' => false,
			'default' => null,
			'length' => 255],
		
		'xenbridge_enable' => [
			'type' => 'boolean',
			'null' => false,
			'default' => 0,
			'length' => 1],

		'tableParameters' => [
			'charset' => 'utf8', 
			'collate' => 'utf8_general_ci', 
			'engine' => 'InnoDB']
	];
}