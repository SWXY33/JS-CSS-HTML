<?php

namespace common\models;

use Yii;
use common\components\RecordModel;
use common\components\SException;

class School extends RecordModel
{

    const STATE_CHECK = 0;
    const STATE_NORMAL = 1;
    const STATE_NOT_CHECK = -1;

    public static $stateList = array(
        self::STATE_NORMAL => '正常',
        self::STATE_CHECK => '审核中',
        self::STATE_NOT_CHECK => '审核未通过',
    );

    public static function primaryColumn()
    {
        return 'schoolId';
    }

    /**
     * 新增学校
     * @param $schoolName
     * @param $district
     * @param $lon
     * @param $lat
     * @param $contactName
     * @param $contactPhone
     * @return mixed
     */
    public static function addSchool($schoolName,$contactName,$contactPhone,$province,$city,$district,$address,$lon,$lat,$zoneId,$state=self::STATE_NORMAL) {

        $data = [
            'schoolName'=>$schoolName,
            'contactName'=>$contactName,
            'contactPhone'=>$contactPhone,
            'province'=>$province,
            'city'=>$city,
            'district'=>$district,
            'address'=>$address,
            'lon'=>$lon,
            'lat'=>$lat,
            'zoneId'=>$zoneId,
            'state'=>$state,
        ];

        return self::create($data);

    }

    public function getSchoolStateName(){
        return self::$stateList[$this->state];
    }

    /**
     * 删除学校
     * @return bool
     */
    public function delSchool(){
        $this->log('删除');
        return parent::delete();
    }

    /**
     * 设置区域
     * @param $lon
     * @param $lat
     * @return bool
     */
    public function setCoordinate($lon,$lat){
        $this->lon = $lon;
        $this->lat = $lat;
        $this->log('学校区域经纬度设置为'.$lon.','.$lat);
        return $this->saveAttributes(['district','lon','lat']);
    }

    /**
     * 设置地址
     * @param $province
     * @param $city
     * @param $district
     * @param $address
     * @param $lon
     * @param $lat
     * @param $zoneId
     * @return bool
     */
    public function setAddress($province,$city,$district,$address,$lon,$lat,$zoneId=''){
        $this->province = $province;
        $this->city = $city;
        $this->district = $district;
        $this->address = $address;
        $this->lon = $lon;
        $this->lat = $lat;
        $this->zoneId = $zoneId;
        $this->log('地址由'.$this->province.$this->city.$this->district.$this->address.'改为'.$province.$city.$district.$address.'经纬度由'.$this->lon.$this->lat.'改为'.$lon.$lat.'所属区域'.$this->zoneId.'改为'.$zoneId);
        return $this->saveAttributes(['province','city','district','address','lon','lat','zoneId']);
    }

    /**
     * 设置联系人
     * @param $contactName
     * @param $contactPhone
     * @return bool
     */
    public function setContact($contactName='',$contactPhone=''){
        $this->contactName = $contactName;
        $this->contactPhone = $contactPhone;
        $this->log('学校联系人由'.$this->contactName.$this->contactPhone.'改为'.$contactName.$contactPhone);
        return $this->saveAttributes(['contactName','contactPhone']);
    }

    /**
     * 审核学校通过
     * @return bool
     */
    public function checkSchool(){
        $this->state = self::STATE_NORMAL;
        $this->log('管理员('.Yii::$app->session->get('adminId').')审核学校['.$this->schoolId.']通过。');
        return $this->saveAttributes(['state']);
    }

    /**
     * 审核学校未通过
     * @return bool
     */
    public function notCheckSchool(){
        $this->state = self::STATE_NOT_CHECK;
        $this->log('管理员('.Yii::$app->session->get('adminId').')审核学校['.$this->schoolId.']不通过。');
        return $this->saveAttributes(['state']);
    }

    /**
     * 获取学校名称
     * @return mixed|null
     */
    public function getSchoolName(){
        return $this->schoolName;
    }

    public function getSchoolFullName(){
        return $this->getSchoolAddress().$this->schoolName;
    }

    /**
     * 获取地区
     * @return mixed|null
     */
    public function getRegionValue(){
        $regionValue  = '';
        if (!empty($this->province)&& !empty($this->city) && !empty($this->district)) {
            $regionValue = ['0'=>$this->province,'1'=>$this->city,'2'=>$this->district];
        }
        return $regionValue;
    }

    /**
     * 获取区域信息
     * @return bool
     */
    public function getZoneInfo(){
        return '';
        
    }

    /**
     * 获取区域名称
     * @return bool
     */
    public function getZoneName(){
        return '';
    }

    public function getProvinceName(){
        return '';
    }

    public function getCityName(){
        return '';
    }

    public function getDistrictName(){
        return '';
    }

    /**
     * 获取学校坐标
     * @return string
     */
    public function getCoordinate(){
        if(!empty($this->lon)&&!empty($this->lat)){
            return  $this->lon.','.$this->lat;
        }
        return '';
    }

    public function getStudentCount(){
        return Student::getRecordCount(['schoolId'=>$this->schoolId]);
    }

    public function getCardCount(){
        return Card::getRecordCount(['schoolId'=>$this->schoolId]);
    }

    public function getDeviceCount(){
        return Device::getRecordCount(['schoolId'=>$this->schoolId]);
    }

    public function getUserCount(){
        return Card::getRecordCount("schoolId={$this->schoolId} and userId>0");
    }

    public function getDeviceDayCount($day){
        return Device::getRecordCount("schoolId={$this->schoolId} and createTime BETWEEN UNIX_TIMESTAMP('{$day} 00:00:00') and UNIX_TIMESTAMP('{$day} 23:59:59')");
    }

    public function getCardDayCount($day){
        return Card::getRecordCount("schoolId={$this->schoolId} and createTime BETWEEN UNIX_TIMESTAMP('{$day} 00:00:00') and UNIX_TIMESTAMP('{$day} 23:59:59')");
    }

    /**
     * 获取当前学校所属区域ID以及上级ID列表
     * 用于下拉选择区域回显
     */
    public function getSelectZoneList(){
        if(!empty($this->zoneId)){
            return Zone::getInstance($this->zoneId)->getSelectZoneList();
        }else{
            return [];
        }
    }

    public function getAccess(){
        $tableName = static::tableName();
        $primaryColumn = static::primaryColumn();
        $relativeId = $this->$primaryColumn;
        $access = Access::multiLoadRow("relativeType = '$tableName' and relativeId = '$relativeId'");
        if( empty($access) ){
            $access = Access::addAccess($tableName,$this->schoolId);
        }
        return $access;
    }

    public function getAccessId(){
        return $this->getAccess()->getAccessId();
    }

    public function checkSchoolAccess($phone){
        $schoolId = $this->schoolId;
        $access = Access::multiLoadRow("relativeType = 'school' and relativeId = '$schoolId'");
        if (empty($access)) {
            return true;
        }
        return AccessModel::getInstance()->checkAccess($access,$phone);
    }

    public function getLinePrefix(){
        $line =  RouteModel::getInstance()->getSpareLine($this->schoolId);
        $linePrefix = $line->getLinePrefix();
        return RouteModel::getInstance()->checkRoute($linePrefix);
    }

    /**
     * 获取学校省市区名称
     * @return bool
     */
    public function getSchoolAddress(){
        return '';
    }

    /**
    * 获取学校ID
    */
    public function getSchoolId(){
        return $this->schoolId;
    }

}