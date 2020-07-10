<?php

namespace frontend\controllers;

use Yii;
use common\models\UserModel;
use \common\components\Controller; 

class BaseController extends Controller {
    public $pageTitle = '';
    public $userId = 0;
    private $_filter_list = array(
        'base',
        'index',
        'test'
    );

    public function init(){
        parent::init();
        $data = $this->request->post();
        if( !empty($data['inviteId']) ) {
            Yii::$app->session->set('inviteId',intval($data['inviteId']));
        }
        if (!empty($data['version'])) {
            if( !$this->_check_filter($this->id,$this->module->requestedRoute)&&!UserModel::getInstance()->isLogin()){
                if(!empty($data['token'])&&UserModel::getInstance()->tokenLogin($data['token']) ){  
                    //login success  do nothing
                }
                else {
                    $this->message('token invalid',999);
                }
                
            }
        }

        
        // $this->userId = UserModel::getInstance()->getLoginUserId();
        Yii::$app->params['pageId'] = Yii::$app->getView()->params['pageId'] = $this->id;
    }

    protected function displayData($data = array(), $params = array()){
        parent::displayData($data,$params);
    }



    private function _check_filter($id,$method){
        //var_dump($id,$method);
        if( in_array($id,$this->_filter_list)||in_array($method,$this->_filter_list) ) {
            return true;
        }
        else {
            return false;
        }
    }
}

