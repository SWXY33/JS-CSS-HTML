<?php

namespace common\models;

use Yii;
use common\components\RecordModel;

class Region extends RecordModel {


    public static function primaryColumn(){
        return 'id';
    }

    public function getFullName(){
        return $this->getParentName().$this->getName();
    }

    public function getParentName(){
        return empty($this->parentId)||$this->parentId==1?'':Yii::$app->objectLoader->load(get_called_class(),$this->parentId)->getFullName();
    }

    public function getChildList(){
        $parentId = $this->id;
        $regionList = self::multiLoad("parentId = $parentId");
        $list = [];
        foreach ($regionList as $region) {
            $data['id'] = $region->getId();
            $data['name'] = $region->getName();
            $list[] = $data;
        }
        return $list;
    }

    public function getParentId(){
        return $this->parentId;
    }

    public static function getSimpleName($region_id){
        if (empty($region_id)) {
            return null;
        }
        $region = self::multiLoad(['id' => $region_id]);
        $region = reset($region);
        return($region->getName());
    }

    /**
     * 获取当前地区ID以及上级ID列表
     * @return array
     * @throws \common\components\CException
     */
    public function getRegionIdList(){
        $list = [$this->id];
        if(!empty($this->parentId)){
            $list = array_merge(self::getInstance($this->parentId)->getRegionIdList(),$list);
        }
        return $list;

    }

    public function getId(){
        return $this->id;
    }

}