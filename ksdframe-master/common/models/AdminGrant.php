<?php
/**
 *
 *
 */

namespace common\models;

use Yii;
use common\components\RecordModel;


class AdminGrant extends RecordModel {

    public static $dataKeys = array(
        'adminGrantId','name','parentId','tag',
        'url','icon','parentIdName'
    );

    public static function primaryColumn(){
        return 'adminGrantId';
    }

    public static function add($data){
        return self::create($data);
    }

    public function getChildren(){
        return self::multiLoad(['parentId' => $this->adminGrantId,'type'=>1],'orderby asc');
    }

    public function getName(){
        return $this->type == 2 ? $this->name.'(字段权限)' : $this->name;
    }

    public static function getAll($parentId=0){
        return self::multiLoad(['parentId' => $parentId]);
    }

    public static function getAllGrant(){
        return self::multiLoad();
    }

    public function getParentTag(){
        return empty($this->parentId)?'':Yii::$app->objectLoader->load('\common\models\AdminGrant',$this->parentId)->getTag();
    }

    public function getParentId(){
        return $this->parentId;
    }

    public function getParentName(){
        return empty($this->parentId)?'顶级':Yii::$app->objectLoader->load('\common\models\AdminGrant',$this->parentId)->getName();
    }

    // 根据子级的parentId获取父级的name
    public function getParentIdName($parentId=0){
        return $this->getParentName();
    }

    public function getTypeName(){
        if($this->type==1){
           return $this->type="菜单权限";
        }elseif($this->type==2){
           return $this->type="字段权限";
        }
    }


}