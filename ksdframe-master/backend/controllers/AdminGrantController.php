<?php

namespace backend\controllers;

use Yii;
use common\models\AdminGrant; 
use common\models\AdminRole; 
use common\models\Admin; 
use common\models\AdminModel; 
use common\models\AdminGrantModel;
 
class AdminGrantController extends BaseController {

    public function actionGrantList(){
        return $this->render('grantList');
    }

    public function actionAddGrant(){
        return $this->render('addGrant');
    }

    public function actionGetAdminGrant(){

      $adminRole = AdminModel::getInstance()->getLoginAdmin()->getRole();
      $adminGrant = AdminGrantModel::getInstance()->getAdminGrantByRole($adminRole);
      if (!$adminGrant) {
          $this->error('非法访问');
      }else{
          $this->displayData($adminGrant);
      }
    }

    public function actionCheckGrantName(){
        $name = Yii::$app->request->post('name'); 
        $grantList = AdminGrant::multiLoad("name = '$name'");
        if (!empty($grantList)) {
           $this->displayData(true);
        }else{
           $this->displayData(false);
        }
    }
    public function actionCheckGrantTag(){
        $tag = Yii::$app->request->post('tag'); 
        $reslut = AdminGrant::multiLoad("tag = '$tag'");
        if (!empty($reslut)) {
           $this->displayData(true);
        }else{
           $this->displayData(false);
        }
    }

    public function actionAddGrantData(){

        try {
          $data = Yii::$app->request->post();
          $adminGrantModel = new AdminGrantModel();
          $data = $adminGrantModel -> addAdminGrant($data['addBase']);
          $this->displayData($data);
        } catch (SException $e) {
            $this->error($e->getMessage());
        }

    }

    public function actionUpdateGrantData(){
          try{
              $data = Yii::$app->request->post();
              $this->displayData(AdminGrant::getInstance($data['adminGrantId'])->update($data['addBase']));
          }catch (SException $e){
              $this->error($e->getMessage());
          }
    }

    public function actionGetGrantDataInfo()
    {
        try {
            $adminGrantId = Yii::$app->request->post('adminGrantId');
            $grantInfo = AdminGrant::getInstance($adminGrantId)->getDataArray(['adminGrantId', 'name', 'type', 'parentId', 'tag', 'url', 'icon', 'orderby']);
            $this->displayData($grantInfo);
        } catch (SException $e) {
            $this->error($e->getMessage());
        }
    }

    public function actionGetList(){
          $keytype = !empty(Yii::$app->request->post('keytype'))?Yii::$app->request->post('keytype'):'';
          $keyword = !empty(Yii::$app->request->post('keyword'))?Yii::$app->request->post('keyword'):'';
          $grantType = Yii::$app->request->post('grantType');
          $showType  = Yii::$app->request->post('showType');

          $getAdminGrantList = new AdminGrantModel();
          $data = $getAdminGrantList -> getAdminGrantList($keytype,$keyword,$grantType,$showType,$this->getPageLimit());
          $this->displayData($data);
    }

    public function actionRemoveGrant(){
        $adminGrantId = yii::$app->request->post("adminGrantId");
         if(empty($adminGrantId)){
            $this->error("错误的ID");
        }else{
            $Role = Yii::$app->objectLoader->load('\common\models\AdminGrant',$adminGrantId);
            if ($Role->parentId == 0 && $Role->type == 1) {
              $this->error("禁止删除顶级权限");
            }
            $Role->delete();
            $this->success("删除成功");
        }
    }

      public function actionGrantListData() {
        $list = array();
        foreach (AdminGrant::getAll(0) as $key => $firstGrant) {
            $list[$key]['firstName'] = $firstGrant->getName();
            $list[$key]['adminGrantId'] = $firstGrant->getAdminGrantId();
            foreach (AdminGrant::getAll($firstGrant->getAdminGrantId()) as $secondGrant) {
                $list[$key]['secondList'][] =  $secondGrant->getName();
            }
        }
        $this->displayData($list);
    }

}