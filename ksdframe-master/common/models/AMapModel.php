<?php
namespace common\models;


use common\components\AMap;
use common\components\Model;

class AMapModel extends Model {

    const AMAP_WEBAPI_KEY = '7f0e87fb57a7b93effad5d1f64cffd48';


    public function getGeoByAddress($address,$fullResult=0){
        $result = $this->getAmap()->getCodeGeo($address);
        if($fullResult) return $result ;
        $geo = array();
        if(!empty($result['location'])){
            $geo = explode(',',$result['location']);
        }
        return ['lng'=>isset($geo[0])?$geo[0]:'','lat'=>isset($geo[1])?$geo[1]:''];
    }


    public function getAddressByGeo($lng,$lat){
        $location = $lng.','.$lat;
        $result = $this->getAmap()->getGeo($location);
        return !empty($result['formatted_address'])?$result['formatted_address']:'';
    }

    public function getAmap(){
        static $amap = null;
        if(empty($amap)) {
            $amap = new AMap(self::AMAP_WEBAPI_KEY);
        }
        return $amap;
    }

}
