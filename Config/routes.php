<?php
/**
 * Kenshimdev : Développeur web et administrateur système (https://kenshimdev.fr/)
 * @author        Kenshimdev - https://kenshimdev.fr
 * @copyright     Kenshimdev - All rights reserved
 * @link          http://mineweb.org/market
 * @since         18.01.2017
 */

Router::connect('/admin/xenbridge', ['controller' => 'Xenbridge', 'action' => 'index', 'plugin' => 'XenBridge', 'admin' => true]);