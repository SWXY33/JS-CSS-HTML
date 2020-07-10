<?php

namespace backend\controllers;

use common\models\AdminGrantModel;
use common\models\PaymentMethod;
use common\models\UserRank;
use common\models\AdminModel;
use common\models\AdminRole;
use common\models\AdminGrant;
use Yii;
use common\models\OilRecord;
use yii\imagine\Image;

class IndexController extends BaseController {

    public function actionIndex(){
        return $this->displayHtml('index',array(
			'adminMessageUrl' => $this->createUrl("shop/page?key=adminMessage"),
		));
        
    }

    public function actionHome(){

        return $this->render('home');
        
    }

    public function actionJsData(){

        
        $tagList = [];
        if ($admin = AdminModel::getInstance()->getLoginAdmin()) {
            $tagList = AdminRole::getInstance($admin->getRoleId())->getTagList();
        }
        $appData = array(
            'tag' => $tagList
        );
        $appData['adminGrantTopList'][0] = array(
            'value' => 0,
            'label' => '顶级'
        );
        foreach (AdminGrantModel::getInstance()->getTopList() as $key => $grant) {
            $appData['adminGrantTopList'][] = array(
                'value' => $grant->getAdminGrantId(),
                'label' => $grant->getName(),
            );
        }
        header('Content-type:text/javascript');
        echo "var AppData = ".json_encode($appData);
        exit;
    }

    private function _config_to_js($list,$valueKey,$labelKey){
        $result = array();
        $valueMethod = 'get'.$valueKey;
        $labelMethod = 'get'.$labelKey;
        foreach( $list as $obj ){
            $result[] = array(
                'value' => $obj->$valueMethod(),
                'label' => $obj->$labelMethod(),
            );
        }
        return $result;
    }

}