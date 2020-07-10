<?php

namespace common\models;

use Yii;
use common\components\Model;
use common\components\SException;

class SchoolModel extends Model
{

    public static $dataKeys = ['schoolId','schoolName','district','lon','lat','contactName','contactPhone','schoolStateName','provinceName','cityName','districtName','address','regionValue','zoneName','zoneId','schoolFullName','schoolAddress'];

    /**
     * 获取学校列表
     * @param $keytype
     * @param $keyword
     * @param $page
     * @param $pageSize
     * @return array
     */

    public function getSchoolList($keytype,$keyword,$zoneId="",$limit,$state="",$regionIdList=""){
        $orderby = ' schoolId DESC ';
        $condition = '1';

        if (!empty($keyword)) {
            $condition .=" AND $keytype LIKE '%$keyword%' ";
        }

        if (!empty($state) || $state == '0') {
            $condition .=" AND state = $state ";
        }

        $data = School::multiLoad($condition,$orderby,$limit);
        $list = array();
        foreach ($data as $d){
            $list['list'][] = $d -> getDataArray(self::$dataKeys);
        }
        $list['total'] = intval(School::getRecordCount($condition));
        return $list;

    }
    /**
     * 导出学校列表
     * @param $keytype
     * @param $keyword
     * @param $page
     * @param $pageSize
     * @return array
     */
	public function getExportSchoolList($keytype,$keyword,$page,$pageSize){
        $page = intval($page) ?: 1;
        $pageSize = min(intval($pageSize) ?: $pageSize, 100);
        $orderby = ' schoolId ASC ';
        $offset = ($page-1)*$pageSize;
        $limit = $offset . ',' . $pageSize;

        $condition = '1';

        if (!empty($keyword)) {
            $condition .=" AND $keytype LIKE '%$keyword%' ";
        }

        $data = School::multiLoad($condition,$orderby,$limit);
        $list = array();
        foreach ($data as $d){
            $list[] = $d -> getDataArray();
        }
        return $list;

    }

    /**
     * 根据区域获取学校列表
     * @return array
     */
    public function getSchoolListByZoneId($zoneId){
        return School::multiLoad(['zoneId'=>$zoneId]);
    }

    /**
     * 获取下拉选择学校列表
     * @return $schoolList
     */
    public function getSelectSchoolList(){
        $schoolList = School::multiLoad(" state = ".School::STATE_NORMAL);
        return  $schoolList;
    }

    /**
     * 获取卡信息
     * @param $cardId
     * @return array
     */
    public function getSchoolInfo($schoolId){
        if (empty($schoolId) || !($school = School::getInstance($schoolId)) || !($school->isExists())) {
            return [];
        }
        return $school->getDataArray(self::$dataKeys);
    }

    /**
     * 根据县ID获取学校列表
     * @param $districtId
     * @return array
     */
    public function getSchoolListByDistrict($districtId){
        $schoolList = School::multiLoad(' district = '.$districtId);
        $list = [];
        if($schoolList){
            foreach ($schoolList as $school) {
                $list[] = $school->getDataArray(['schoolId','schoolName','district','lon','lat','contactName','contactPhone','schoolStateName','provinceName','cityName','districtName','address','regionValue','zoneName','zoneId']);
            }
        }
        return $list;
    }

    /**
     * 获取选择地区学校列表联动数据--增加通过代理商的区域控制
     * @param $regionIdList
     * @return array
     */
    public function getRegionSchoolList($regionIdList='',$newZoneArr=[]){

        $regionSchoolIdList = array();
        $schoolCondition = '1';
        if (!empty($regionIdList)) {

            if (!empty($newZoneArr)) {
                if (count($newZoneArr)>1){
                    $str = implode(',',$newZoneArr);
                    $sql = " and zoneId in(".$str.") ";
                }else{
                    $sql = " and zoneId = ".$newZoneArr[0];
                }
            }else{
                $sql = '';
            }

            if (!empty($regionIdList[2])) {
                $district = $regionIdList[2];
                $schoolCondition .=" AND district = $district ";
                $schoolCondition .= $sql;
            }
            if (!empty($regionIdList[1])) {
                $city = $regionIdList[1];
                $schoolCondition .=" AND city = $city ";
                $schoolCondition .= $sql;
            }
            if (!empty($regionIdList[0])) {
                $province = $regionIdList[0];
                $schoolCondition .=" AND province = $province ";
                $schoolCondition .= $sql;
            }
        }else{
            if (!empty($newZoneArr)) {
                if (count($newZoneArr)>1){
                    $str = implode(',',$newZoneArr);
                    $sql = " zoneId in(".$str.") ";
                }else{
                    $sql = " zoneId = ".$newZoneArr[0];
                }
            }else{
                $sql = '';
            }
            $schoolCondition = $sql;

        }
        $schoolList = School::multiLoad($schoolCondition);
        foreach ($schoolList as $school){
            $regionSchoolIdList['list'][] = $school->getDataArray(['schoolId','schoolName']);
        }
        return $regionSchoolIdList;
    }

    /*
    * 根据地区ID，学校名称获取学校ID列表
    */
    public function getSchoolIdList($regionIdList,$schoolName=''){

        $condition = "1";
        if (!empty($regionIdList)) {
            if (!empty($regionIdList[2])) {
                $district = $regionIdList[2];
                $condition .=" AND district = $district ";
            }
            if (!empty($regionIdList[1])) {
                $city = $regionIdList[1];
                $condition .=" AND city = $city ";
            }
            if (!empty($regionIdList[0])) {
                $province = $regionIdList[0];
                $condition .=" AND province = $province ";
            }
        }
        if(!empty($schoolName)){
            $condition .=" AND schoolName LIKE '%$schoolName%' ";
        }
        $schoolList = School::multiLoad($condition);
        $list = [];
        if($schoolList){
            foreach ($schoolList as $s) {
                $list[] = $s -> getSchoolId();
            }
        }
        return $list;
    }



}