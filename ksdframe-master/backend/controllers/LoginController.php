<?php

namespace backend\controllers;

use Yii;
use \common\components\Controller;
use common\models\AdminModel; 
use common\models\Admin; 
 
class LoginController extends Controller {


    public $layout = 'base'; //不使用布局

    public function actionIndex(){

        return $this->render('index');
        
    }

    public function actionIn(){
        $data = Yii::$app->request->post();
        $result = AdminModel::getInstance()->setLoginByAdminPwd($data['username'],$data['password']);
        if($result){
            if( !empty($data['remember']) ) {
                //在cookie中记录加密的用户用户登录信息
            }
            $this->success('登录成功');
        }else{
            $this->error('用户名或密码错误');
        }
    }

    public function actionOut(){
        AdminModel::setLogout();
        $this->success('退出成功');

    }

}