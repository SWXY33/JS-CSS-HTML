<?php

namespace backend\controllers;

use common\components\SException;
use common\models\ZoneModel;
use Yii;
use common\models\Admin; 
use common\models\AdminModel; 
use common\models\AdminRoleModel;


class AdminController extends BaseController{

    public function actionAddAdminDialog(){
        $this->displayHtml('addAdmin');
    }

    public function actionAdminList(){
        $this->displayHtml('adminList');
    }

    public function actionSetting(){
        $this->displayHtml('setting');
    }

    public function actionUpdatePasswordDialog(){
        $this->displayHtml('updatePassword');
    }

    public function actionSetMenu(){
        $isCollapse = $this->request->post("isCollapse");
        $admin = AdminModel::getInstance()->getLoginAdmin();
        $admin->isCollapse = intval($isCollapse)>0?1:0;
        $admin->saveAttributes( array('isCollapse') );
        $this->success();

    }

    /**
     * 获取管理员列表
     */
    public function actionGetAdminList(){
        $data = $this->request->post('admin');
        $keytype = !empty($data['keytype'])?$data['keytype']:'';
        $keyword = !empty($data['keyword'])?$data['keyword']:'';
        $adminList = AdminModel::getInstance() -> getAdminList($keytype, $keyword, $this->getPageLimit());
        $list = [];
        if (!$adminList) {
            $this->displayData($list);
        }
        foreach ($adminList as $admin) {
            $list['list'][] = $admin->getDataArray(['adminId','adminName','adminTrueName','state','adminStateName','content','zoneName','roleId','roleName']);
        }
        $list['total'] = AdminModel::getInstance()->getAdminCount($keytype, $keyword);
        $this->displayData($list);
    }

    /**
     *更新密码
     * @throws \common\components\CException
     */
    public function actionUpdateAdminPassword(){
        $data = $this->request->post('admin');
        if (!empty($data['newPassword'])) {
            AdminModel::getInstance()->updatePassword($data['newPassword']);
            $this->success('修改成功！');
        }else{
            $this->error('未修改成功');
        }
    }

    /**
     * 校验管理员是否存在
     * @param $adminId
     * @return array|mixed
     * @throws \common\components\CException
     */
    public function checkAdmin($adminId)
    {
        if (empty($adminId) || !($admin = Admin::getInstance($adminId)) || !($admin->isExists())) {
            return [];
        }
        return $admin;
    }

    /**
     * 删除管理员
     */
    public function actionDelAdmin(){
        try {
            $adminList = $this->request->post('adminList');
            foreach ($adminList as $admin){
                $adminId = $admin['adminId'];
                if (!($admin = $this->checkAdmin($adminId))) {
                    $this->error("获取管理员失败");
                }
                $admin->delete();
            }
            $this->success("删除管理员成功");
        } catch (SException $e) {
            $this->error($e->getMessage());
        }
    }

    /**
     * 激活管理员
     * @throws \common\components\CException
     */
    public function actionActiveAdmin(){
        try {
            $adminList = $this->request->post('adminList');
            foreach ($adminList as $admin){
                $adminId = $admin['adminId'];
                if (!($admin = $this->checkAdmin($adminId))) {
                    $this->error("获取管理员失败");
                }
                $admin->activeAdmin();
            }
            $this->success("操作成功");
        } catch (SException $e) {
            $this->error($e->getMessage());
        }
    }

    /**
     * 禁用管理员
     * @throws \common\components\CException
     */
    public function actionCloseAdmin(){
        try {
            $adminList = $this->request->post('adminList');
            foreach ($adminList as $admin){
                $adminId = $admin['adminId'];
                if (!($admin = $this->checkAdmin($adminId))) {
                    $this->error("获取管理员失败");
                }
                $admin->closeAdmin();
            }
            $this->success("操作成功");
        } catch (SException $e) {
            $this->error($e->getMessage());
        }
    }

    /**
     * 更新管理员信息
     * @throws \common\components\CException
     */
    public function actionUpdateAdmin(){
        try{
            $data = $this->request->post("admin");
            $adminId = $this->request->post("adminId");
            $admin = $this->checkAdmin($adminId);
            if($admin){
                $zoneNameList = !empty($data['zoneNameList'])?$data['zoneNameList']:[];
                if(!empty($zoneNameList)){
                    $data['zoneId'] = implode(',',ZoneModel::getInstance()->getZoneIdListByNameList($zoneNameList));
                }else{
                    $data['zoneId'] = '';
                }
                $this->displayData($admin->update($data));
            }else{
                $this->error("更新失败");
            }
        }catch (SException $e){
            $this->error($e->getMessage());
        }
    }

    /**
     * 获取当前登录管理员信息
     * @throws \common\components\CException
     */
    public function actionGetLoginAdminInfo(){
        $admin = AdminModel::getInstance()->getLoginAdmin();
        $adminInfo = $admin->getDataArray(['adminTrueName','roleName','roleId']);
        $this->displayData($adminInfo);
    }

    /**
     * 获取管理员信息
     * @throws \common\components\CException
     */
    public function actionGetAdminInfo()
    {
        try {
            $adminId = $this->request->post('adminId');
            if (!($admin = $this->checkAdmin($adminId))) {
                $this->error("获取管理员失败");
            }
            $adminInfo = $admin->getDataArray(['adminName','adminId','adminTrueName','mobile','roleId','zoneNameList','content']);
            $this->displayData($adminInfo);
        } catch (SException $e) {
            $this->error($e->getMessage());
        }
    }

    /**
     * 新增管理员
     */
    public function actionAddAdmin(){
        try{
            $data = $this->request->post("admin");
            $adminName = $data['adminName'];
            if(empty($adminName)){
                $this->error("管理员用户名不能为空");
            }
            $adminTrueName = !empty($data['adminTrueName'])?$data['adminTrueName']:'';
            if(empty($adminTrueName)){
                $this->error("管理员姓名不能为空");
            }
            $mobile = !empty($data['mobile'])?$data['mobile']:'';
            $roleId = !empty($data['roleId'])?$data['roleId']:0;
            $password = !empty($data['password'])?$data['password']:'';
            $content = !empty($data['content'])?$data['content']:'';
            $zoneNameList = !empty($data['zoneNameList'])?$data['zoneNameList']:[];
            if(!empty($zoneNameList)){
                $zoneId = implode(',',ZoneModel::getInstance()->getZoneIdListByNameList($zoneNameList));
            }else{
                $zoneId = '';
            }
            $admin = Admin::addAdmin($adminName, $adminTrueName, $password, $mobile, $roleId, $zoneId, $content);
            if($admin){
                $this->success("新增管理员成功");
            }else{
                $this->error("新增管理员失败");
            }
        }catch (SException $e){
            $this->error($e->getMessage());
        }
    }


}

?>