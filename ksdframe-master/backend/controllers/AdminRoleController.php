<?php

namespace backend\controllers;

use Yii;
use common\models\AdminGrantModel;
use common\models\AdminRoleModel;
use common\models\AdminRole;
use common\models\region;
class AdminRoleController extends BaseController{


    public function actionRole(){
        return $this->render('role');
    }

    public function actionAddRole(){
        return $this->render('addRole');
    }

    public function actionAddRoleData(){
       
        $data = Yii::$app->request->post();
        $name= $data['roleData']['roleName'];
        $tagNameList=$data['roleData']['kindName'];
        $content= $data['roleData']['roleContent'];
        $tagListArray = [];
        foreach ($tagNameList as $key => $tagName) {
            $tag = AdminGrantModel::getInstance()->getGrantTag($tagName);
            $tagListArray[] = $tag;
        }
        $tagList=implode(",",$tagListArray);
        $orderby="";
        $data = AdminRoleModel::getInstance()->addAdminRole($name,$tagList,$content,$orderby);
        $this->displayData($data);

    }

    public function actionUpdateRoleData(){
       
        $data = Yii::$app->request->post();
        $adminRoleId= $data['roleId'];
        $name= $data['roleData']['roleName'];
        $tagNameList=$data['roleData']['kindName'];
        $content= $data['roleData']['roleContent'];
        $tagListArray = [];
        foreach ($tagNameList as $key => $tagName) {
            $tag = AdminGrantModel::getInstance()->getGrantTag($tagName);
            $tagListArray[] = $tag;
        }
        $tagList=implode(",",$tagListArray);
        $orderby="";
        $data = array(
          'name' => $name, 
          'grantTagList' => $tagList, 
          'content' => $content, 
        );
        $data = AdminRole::getInstance($adminRoleId)->update($data);
        $this->displayData($data);

    }

    public function actionGetRoleInfo(){

        $adminRoleId = Yii::$app->request->post('adminRoleId');
        $adminRole = AdminRole::getInstance($adminRoleId);
        $tagList = explode(",",$adminRole->getTagListName());
        $adminRoleInfo = $adminRole->getDataArray(['adminRoleId', 'name', 'content']);
        $adminRoleInfo['tagList'] = $tagList;
        $this->displayData($adminRoleInfo);

    }

    public function actionGetRoleList(){
        $keytype = !empty(Yii::$app->request->post('keytype'))?Yii::$app->request->post('keytype'):'';
        $keyword = !empty(Yii::$app->request->post('keyword'))?Yii::$app->request->post('keyword'):'';
        
        $adminRoleModel = new AdminRoleModel();
        $role = $adminRoleModel -> getRoleList($keytype,$keyword,$this->getPageLimit());
        
        $this->echoJsonData($role);

    }

     public function actionDelAdminRole(){
         $adminRoleId = Yii::$app->request->post("adminRoleId");
           
          if(empty($adminRoleId)){
            $this->error("错误的ID");
        }else{
            $Role = Yii::$app->objectLoader->load('\common\models\AdminRole',$adminRoleId);
            $Role->delete();
            $this->success("删除成功");
        }

     }

     public function actionGetSelectRoleList(){
        $roleList = AdminRole::multiLoad();
        $list = [];
        foreach ($roleList as $key => $role) {
            $data = array(
                'roleId' => $role->adminRoleId, 
                'roleName' => $role->name, 
            );
            $list[] = $data;
        }
        $this->displayData($list);
     }


}