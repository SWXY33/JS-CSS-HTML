<?php

namespace backend\controllers;

use common\components\SException;
use common\models\School;
use common\models\SchoolModel;
use common\models\AccessModel;
use common\models\AdminModel;
use common\models\AuditModel;
use common\models\Zone;
use common\models\ZoneModel;
use Yii;

class SchoolController extends BaseController {

    public function actionSchoolList()
    {
        $this->displayHtml('schoolList');
    }
    
    public function actionAddSchoolList()
    {
        $this->displayHtml('addSchool');
    }

    public function actionUpdContactList()
    {
        $this->displayHtml('updContact');
    }

    public function actionUpdDistrictList()
    {
        $this->displayHtml('updDistrict');
    }

    public function actionSchoolOperation()
    {
        $this->displayHtml('schoolOperation');
    }

    /**
     * 校验学校是否存在
     * @param $schoolId
     * @return array|mixed
     * @throws \common\components\CException
     */
    public function _check_school($schoolId)
    {
        if (empty($schoolId) || !($school = School::getInstance($schoolId)) || !($school->isExists())) {
            return [];
        }
        return $school;
    }

    /**
     * 新增学校
     * @param $schoolName
     * @param $province
     * @param $city
     * @param $district
     * @param $address
     * @param $lon
     * @param $lat
     * @param $contactName
     * @param $contactPhone
     * @return mixed
     */
    public function actionAddSchool(){
        $data = Yii::$app->request->post('school');
        $schoolName = $data['schoolName'];
        $contactName = !empty($data['contactName'])?$data['contactName']:'';
        $contactPhone = !empty($data['contactPhone'])?$data['contactPhone']:'';
        $regionValue = !empty($data['regionValue'])?$data['regionValue']:'';
        $coordinate = !empty($data['coordinate'])?$data['coordinate']:'';
        $zoneIdList = !empty($data['zoneIdList'])?$data['zoneIdList']:[];
        $province='';
        $city='';
        $district='';
        if (!empty($regionValue)) {
            $province = $regionValue['0'];
            $city = $regionValue['1'];
            $district = $regionValue['2'];
        }
        $address = !empty($data['address'])?$data['address']:'';
        $lon = '';
        $lat = '';
        if(!empty($coordinate)){
            $list = explode(',',$coordinate);
            $lon = $list[0];
            $lat = $list[1];
        }
        if(!empty($zoneIdList)){
            $zoneId = end($zoneIdList);
        }else{
            $zoneId = '';
        }
        $auditData = array(
            'schoolName' => $schoolName, 
            'contactName' => $contactName, 
            'contactPhone' => $contactPhone, 
            'province' => $province, 
            'city' => $city, 
            'district' => $district, 
            'address' => $address, 
            'lon' => $lon, 
            'lat' => $lat, 
            'zoneId' => $zoneId, 
            'adminId' => AdminModel::getInstance()->getLoginUid(), 
        );
        if (CONFIG('school_auto_audit')) {
            $audit = AuditModel::getInstance()->addAudit('school',json_encode($auditData));
            if ($audit) {
                $this->success('新增成功');
            }else{
                $this->error('新增失败');
            }
        }else{
            $school = School::addSchool($schoolName,$contactName,$contactPhone,$province,$city,$district,$address,$lon,$lat,$zoneId);
            if ($school) {
                $this->success('新增成功');
            }else{
                $this->error('新增失败');
            }
        }
        
    }

    /**
     * 更新学校信息
     * @throws \common\components\CException
     */
    public function actionUpdateSchool(){
        try{
            $schoolId = $this->request->post('schoolId');
            $school = $this->_check_school($schoolId);
            if(!$school){
                $this->error('操作失败');
            }
            $data = $this->request->post('school');
            $regionValue = !empty($data['regionValue'])?$data['regionValue']:'';
            $coordinate = !empty($data['coordinate'])?$data['coordinate']:'';
            $zoneIdList = !empty($data['zoneIdList'])?$data['zoneIdList']:[];
            if (!empty($regionValue)) {
                $data['province'] = $regionValue['0'];
                $data['city'] = $regionValue['1'];
                $data['district'] = $regionValue['2'];
            }
            if(!empty($coordinate)){
                $list = explode(',',$coordinate);
                $data['lon'] = $list[0];
                $data['lat'] = $list[1];
            }
            if(!empty($zoneIdList)){
                $data['zoneId'] = end($zoneIdList);
            }else{
                $data['zoneId'] = '';
            }
            $school->update($data);
            $this->success();
        }catch (SException $e){
            $this->error($e->getMessage());
        }
    }

    /**
     * 删除学校
     * @return bool
     */
    public function actionDelSchool(){
        $schoolId = Yii::$app->request->post('schoolId');
        $data = $this->_check_school($schoolId)->delSchool();
        if ($data) {
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }

    /**
     * 设置区域
     * @param $district
     * @param $lon
     * @param $lat
     * @return bool
     */
    public function actionSetCoordinate(){
        $school = Yii::$app->request->post('school');
        $lon = $school['lon'];
        $lat = $school['lat'];
        $data = $this->_check_school($school['schoolId'])->setCoordinate($lon,$lat);
        if ($data) {
            $this->success('更改经纬度成功');
        }else{
            $this->error('更改经纬度失败');
        }
    }

    /**
     * 设置地址
     * @param $schoolId
     * @param $province
     * @param $city
     * @param $district
     * @param $address
     * @param $lat
     * @param $lon
     * @return bool
     */
    public function actionSetAddress(){
        $school = Yii::$app->request->post('school');
        $schoolId = $school['schoolId'];
        if (!empty($school['regionValue'])) {
            $province = $school['regionValue']['0'];
            $city = $school['regionValue']['1'];
            $district = $school['regionValue']['2'];
        }
        $address = $school['address'];
        $zoneId = $school['zoneId'];
        $lon = $school['lon'];
        $lat = $school['lat'];
        $data = $this->_check_school($schoolId)->setAddress($province,$city,$district,$address,$lon,$lat,$zoneId);
        if ($data) {
            $this->success('更改地址成功');
        }else{
            $this->error('更改地址失败');
        }
    }

    /**
     * 设置联系人
     * @param $contactName
     * @param $contactPhone
     * @return bool
     */
    public function actionSetContact(){
        $school = Yii::$app->request->post('school');
        $schoolId = $school['schoolId'];
        $contactName = $school['contactName'];
        $contactPhone = $school['contactPhone'];
        $data = $this->_check_school($schoolId)->setContact($contactName,$contactPhone);
        if ($data) {
            $this->success('更改联系人成功');
        }else{
            $this->error('更改联系人失败');
        }
    }

    /**
     * 获取学校列表
     * @param $keytype
     * @param $keyword
     * @param $page
     * @param $pageSize
     * @return array
     */
    public function actionGetSchoolList(){
        $keytype = !empty(Yii::$app->request->post('keytype')) ? Yii::$app->request->post('keytype') : '';
        $keyword = trim(!empty(Yii::$app->request->post('keyword')) ? Yii::$app->request->post('keyword') : '');
        $state = !empty(Yii::$app->request->post('state')) || Yii::$app->request->post('state') == '0' ? Yii::$app->request->post('state') : '';
        $zoneId = !empty($this->request->post('zoneIdList'))?array_slice($this->request->post('zoneIdList'),-1,1):'0';
        //修改默认的区域值
        /*if (!empty($this->request->post('zoneIdList'))) {
            $zoneId = array_slice($this->request->post('zoneIdList'),-1,1);
        }else{
            $admin = AdminModel::getInstance()->getLoginAdmin();
            if ($admin->roleId == 1) {
                //管理员
                $zoneId = '0';
            }else{
                //代理商
                $zoneId = ['0' => $admin->zoneId];
            }
        }*/
//var_dump($zoneId);die;
        try{
            $data = SchoolModel::getInstance()->getSchoolList($keytype,$keyword,$zoneId,$this->getPageLimit(),$state);
            $this->displayData($data);
        } catch (SException $e) {
            $this->error($e->getMessage());
        }
    }

    /**
     * 根据地区获取对应学校列表
     * @param $keytype
     * @param $keyword
     * @param $page
     * @param $pageSize
     * @return array
     */
    public function actionGetRegionSchoolList(){
        $regionIdList = !empty($this->request->post('regionIdList'))?$this->request->post('regionIdList'):'';

        $admin = AdminModel::getInstance()->getLoginAdmin();
        if ($admin->roleId == 1) {
            try{
                $data = SchoolModel::getInstance()->getRegionSchoolList($regionIdList);
                $this->displayData($data);
            } catch (SException $e) {
                $this->error($e->getMessage());
            }
        }else{
            try{
                //获取代理商管理的区域及下级区域组成的数组
                $zone = Zone::getInstance($admin->zoneId);
                $zoneArr = array(
                    'id'=>$zone->zoneId,
                    'label'=>$zone->zoneName
                );
                $childrenZoneArr = ZoneModel::getInstance()->getZoneList($admin->zoneId);
                $zonesArr = array_merge($zoneArr,$childrenZoneArr);
                $newZoneArr = [];
                foreach ($zonesArr as $k=>$v) {
                    if ($k == 'id') {
                        $newZoneArr[] = $v;
                    }
                }

                $data = SchoolModel::getInstance()->getRegionSchoolList($regionIdList,$newZoneArr);
                $this->displayData($data);
            } catch (SException $e) {
                $this->error($e->getMessage());
            }
        }
    }

    /**
     * 审核学校通过
     * @param $schoolId
     * @return bool
     */
    public function actionCheckSchool(){
        $schoolId = Yii::$app->request->post('schoolId');
        $data = School::getInstance($schoolId)->checkSchool();
        if ($data) {
            $this->success('审核通过');
        }else{
            $this->error('审核失败');
        }
    }

    /**
     * 审核学校未通过
     * @param $schoolId
     * @return bool
     */
    public function actionNotCheckSchool(){
        $schoolId = Yii::$app->request->post('schoolId');
        $data = School::getInstance($schoolId)->notCheckSchool();
        if ($data) {
            $this->success('审核未通过');
        }else{
            $this->error('审核失败');
        }
    }

    /**
     * 获取下拉选择学校列表
     */
    public function actionGetSelectSchoolList(){
        try{
            $regionIdList = Yii::$app->request->post('regionIdList');
            if (!empty($regionIdList)) {
                $list = SchoolModel::getInstance()->getRegionSchoolList($regionIdList);
            }else{
                $schoolList = SchoolModel::getInstance()->getSelectSchoolList();
                $list = [];
                if($schoolList){
                    foreach ($schoolList as $school){
                        $list[] = $school->getDataArray(['schoolId','schoolName']);
                    }
                }
            }
            $this->displayData($list);
        }catch (SException $e){
            $this->error($e->getMessage());
        }
    }

    /**
     * 获取学校信息
     * @throws \common\components\CException
     */
    public function actionGetSchoolInfo(){
        $schoolId = Yii::$app->request->post('schoolId');
        try{
            $school = $this->_check_school($schoolId);
            if(!$school){
                $this->error();
            }
            $data = $school->getDataArray(['schoolId','schoolName','regionValue','contactName','contactPhone','address','zoneId','coordinate','selectZoneList']);
            $this->displayData($data);
        }catch (SException $e){
            $this->error($e->getMessage());
        }
    }

    public function actionGetAccess(){
        $schoolId = Yii::$app->request->post('schoolId');
        try{
            $accessId = School::getInstance($schoolId)->getAccessId();
            $access = AccessModel::getInstance()->getAccessData($accessId);
            $this->displayData($access);
        }catch (SException $e){
            $this->error($e->getMessage());
        }
    }
}
