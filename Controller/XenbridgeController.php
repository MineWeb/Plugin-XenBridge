<?php
/**
 * Kenshimdev : Développeur web et administrateur système (https://kenshimdev.fr/)
 * @author        Kenshimdev - https://kenshimdev.fr
 * @copyright     Kenshimdev - All rights reserved
 * @link          http://mineweb.org/market
 * @since         23.01.2017
 */

class XenbridgeController extends AppController{

    /**
     * Called when the route /admin/xenbridge is called.
     */
    public function admin_index(){
        if($this->isConnected && $this->User->isAdmin()){
            $this->layout = 'admin';

            //Load configuration
            $this->loadModel('XenBridge.XBConfiguration');
           	$config = $this->XBConfiguration->find('first')['XBConfiguration'];

            $xenapi_key = (isset($config['xenapi_key'])) ? $config['xenapi_key'] : '';
            $xenapi_fullpath = (isset($config['xenapi_fullpath'])) ? $config['xenapi_fullpath'] : '';
            

            //Load SSLChecker
            App::import('XenBridge.Vendors', 'SSLChecker');
            //Pre-requisite verification https
            $isRequestHttps = SSLChecker::isRequestHttps();
            $isForumHttps = SSLChecker::isUrlHttps($xenapi_fullpath);
            

            //Updating the API
            if ($this->request->is('post')) {
                $data_xenapi_key = $this->request->data["xenapi_key"];
                $data_xenapi_fullpath = $this->request->data["xenapi_fullpath"];

                //Form validation
                if(strlen($data_xenapi_key) < 20 || strlen($data_xenapi_key) > 50){
                    $this->Session->setFlash($this->Lang->get('XENAPI_KEY_LENGTH_ERROR'), 'default.error');
                    return $this->redirect($this->referer());
                }

                if(strlen($data_xenapi_fullpath) < 15){
                    $this->Session->setFlash($this->Lang->get('XENAPI_FULLPATH_LENGTH_ERROR'), 'default.error');
                    return $this->redirect($this->referer());
                }

                //Look if a configuration already exists
                if(empty($xenapi_key) && empty($xenapi_fullpath)){
                    //Add new xenapi key
                    $this->XBConfiguration->create();
                    if ($this->XBConfiguration->save($this->request->data)) {
                        $this->Session->setFlash($this->Lang->get('XENAPI_CONFIG_ADD_SUCCESS'), 'default.success');
                        return $this->redirect($this->referer());
                    }
                }else{
                    //edit current xenapi key
                    $this->XBConfiguration->read(null, $config['id']);
                    $this->XBConfiguration->set('xenapi_key', $this->request->data['xenapi_key']);

                    if(SSLChecker::isRequestHttps() && SSLChecker::isUrlHttps($this->request->data['xenapi_fullpath'])){
                        //Enable Xenbridge plugin
                        $this->XBConfiguration->set('xenapi_fullpath', $this->request->data['xenapi_fullpath']);
                        $this->XBConfiguration->set('xenbridge_enable', true);
                    }else{
                        //Disable Xenbridge plugin
                        $this->XBConfiguration->set('xenbridge_enable', false);
                    }
                    
                    if ($this->XBConfiguration->save()){
                        $this->Session->setFlash($this->Lang->get('XENAPI_CONFIG_EDIT_SUCCESS'), 'default.success');
                        return $this->redirect($this->referer());
                    }
                }

                //error occurred
                $this->Session->setFlash($this->Lang->get('XENAPI_CONFIG_EDIT_ERROR'), 'default.error');
                return $this->redirect($this->referer());
            }

            return $this->set(compact('xenapi_key', 'xenapi_fullpath', 'isRequestHttps', 'isForumHttps'));
        }else{
            return $this->redirect('/');
        }
    }

}