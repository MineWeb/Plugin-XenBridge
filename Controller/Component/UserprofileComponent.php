<?php
/**
 * Kenshimdev : Développeur web et administrateur système (https://kenshimdev.fr/)
 * @author        Kenshimdev - https://kenshimdev.fr
 * @copyright     Kenshimdev - All rights reserved
 * @link          http://mineweb.org/market
 * @since         23.01.2017
 */

class UserprofileComponent extends Component {

    private $XBConfiguration;
    private $xenapi_key;
    private $xenapi_fullpath;
    private $xenbridge_enabled;
    private $stats = [];

    public function __construct($user) {
      $this->XBConfiguration = ClassRegistry::init('XenBridge.XBConfiguration');
      $config = $this->XBConfiguration->find('first')['XBConfiguration'];
      $this->xenapi_key = $config['xenapi_key'];
      $this->xenapi_fullpath = $config['xenapi_fullpath'];
      $this->xenbridge_enabled = $config['xenbridge_enable'];

      App::import('XenBridge.Vendors', 'APIRequest');
      $APIRequest = new APIRequest('XenAPI/1.0', 40);

      if($this->xenbridge_enabled){
        $this->stats = json_decode($APIRequest::exec($this->xenapi_fullpath . '?action=getUser&value=' . $user . '&hash=' . $this->xenapi_key), true);
      }
    }


    /**
     * Verifies that the plugin (XenBridge) is enabled
     */
    public function isEnable()
    {
      return $this->xenbridge_enabled;
    }

    /**
     * Return the number of messages posted by a user on Xenforo
     */
    public function getMessages(){
      return $this->stats['message_count'];
    }

    /**
     * Return the xenforo rank of a user
     */
    public function getRank(){
      if($this->stats['is_admin'] == 1){
        return 'Administrateur';
      }else if($this->stats['is_moderator'] == 1){
        return 'Modérateur';
      }else{
        return 'Membre';
      }
    }

    /**
     * Return the last activity of the user on the forum
     */
    public function getLastActivity(){
      return date('d.m.Y H:i:s', $this->stats['last_activity']);
    }

    /**
     * Return the number of unread conversations
     */
    public function getConversationsUnread(){
      return $this->stats['conversations_unread'];
    }

    /**
     * Return the number of trophy points
     */
    public function getTrophies(){
      return $this->stats['trophy_points'];
    }

    /**
     * Return the number of liked messages
     */
    public function getLikes(){
      return $this->stats['like_count'];
    }

    /**
     * Return the number of warnings
     */
    public function getWarnings(){
      return $this->stats['warning_points'];
    }
}