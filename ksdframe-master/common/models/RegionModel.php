<?php

namespace common\models;

use Yii;
use common\components\Model;

class RegionModel extends Model {

    public function getRegionList(){

        $cache = Yii::$app->cache->get('cacheProvinceDataList');
//$cache = [];
        if (empty($cache)) {
            $provinceList = Region::multiLoad("parentId = 0","id asc");
            $provinceDataList = [];
            foreach ($provinceList as $key => $province) {
               $provinceId = $province->getId();
               $provinceName = $province->getName();
               $provinceData['value'] = $provinceId;
               $provinceData['label'] = $provinceName;
               $cityList = Region::multiLoad("parentId = $provinceId","id asc");
               $cityDataList = [];
               foreach ($cityList as $key => $city) {
                   $cityId = $city->getId();
                   $cityName = $city->getName();
                   $cityData['value'] = $cityId;
                   $cityData['label'] = $cityName;
                   $districtList = Region::multiLoad("parentId = $cityId","id asc");
                   $districtDataList = [];
                   foreach ($districtList as $key => $district) {
                       $districtId = $district->getId();
                       $districtName = $district->getName();
                       $districtData['value'] = $districtId;
                       $districtData['label'] = $districtName;
                       $districtDataList[] = $districtData;
                   }
                   $cityData['children'] = $districtDataList;
                   $cityDataList[] = $cityData;
               }
               $provinceData['children']= $cityDataList;
               $provinceDataList[] = $provinceData;

                $dependency = new \yii\caching\DbDependency([
                    'sql' => 'select count(*) from region'
                ]);

               Yii::$app->cache->set('cacheProvinceDataList', $provinceDataList,2592000,$dependency);
               $cache = $provinceDataList;
            }
        }
        return $cache;

    }

    /**
     * 获取当前区域相关ID列表
     * 编辑区域选择行政区回显
     * @param $regionId
     * @return array
     * @throws \common\components\CException
     */
    public function getCurrentRegionIdList($regionId){
        $list = [];
        array_unshift($list, $regionId);
        $region = Region::getInstance($regionId);
        $parentId = $region->getParentId();
        if(!empty($parentId)){
            array_unshift($list, $parentId);
            $parent = Region::getInstance($parentId);
            $grandId = $parent->getParentId();
            if(!empty($grandId)){
                array_unshift($list, $grandId);
            }
        }
        return $list;
    }

    /**
     * 获取下一级对象
     * @param $regionId
     * @return array
     */
    public function getChildRegionList($regionId){
        return $regionList = Region::multiLoad('parentId = '.$regionId);
    }

    /**
     * 根据地区名称获取地区ID
     * @param $regionName
     * @return string
     */
    public function getRegionIdByName($regionName){
        $region = Region::multiLoadRow(" name = '$regionName'");
        if($region){
            return $region->getId();
        }
        return '';
    }
    /**
     * 根据zoneId管理的学校获取代理商相对应的行政区域列表
     */
    public function getAdminRegionList ($zoneId) {
        $schoolList = Zone::getInstance($zoneId)->getZoneSchoolList();
        $regionList = [];
        $province = [];
        $city = [];
        $district = [];
        foreach ($schoolList as $k=>$v) {
            $regionProvince = Region::getInstance($schoolList[$k]->province);
            $regionCity = Region::getInstance($schoolList[$k]->city);
            $regionDistrict = Region::getInstance($schoolList[$k]->district);

            $district['value'] = $regionDistrict->getId();
            $district['label'] = $regionDistrict->getName();

            $city['value'] = $regionCity->getId();
            $city['label'] = $regionCity->getName();
            $city['children'][] = $district;

            $province['value'] = $regionProvince->getId();
            $province['label'] = $regionProvince->getName();
            $province['children'][] = $city;

        }
        $regionList[] = $province;
//        var_dump($regionList);die;
        return $regionList;
    }
}