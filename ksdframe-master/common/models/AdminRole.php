<?php


namespace common\models;

use Yii;
use common\components\RecordModel;
use common\models\Region;


class AdminRole extends RecordModel {

    public static function primaryColumn(){
        return 'adminRoleId';
    }

    public static function add($name,$grantTagList,$content,$orderby){
        $data = [
            'name' => $name,
            'grantTagList' => $grantTagList,
            'content' => $content,
            'orderby' => $orderby,
        ];
        return self::create($data);
    }

    public function getGrantTagList(){
        return $this->grantTagList ;
    }

    public function getGrantTagArray(){
        if( $this->grantTagList=='ALLGRANTS' ){
            $adminGrantList = AdminGrant::getAllGrant();
            $list = [];
            foreach ($adminGrantList as $adminGrant) {
                $list[] = $adminGrant->getTag();
            }
            return $list;
        }else{
             return explode(',',$this->grantTagList ) ;
        }
       
    }

    public function getName(){
        return $this->name;
    }

    public function getTagListName(){
        $grantTagListArray = $this->getGrantTagArray();
        $list = [];
        foreach ($grantTagListArray as $key => $grantTag) {
            $adminGrant = AdminGrant::multiLoadRow("tag = '$grantTag'");
            if (!empty($adminGrant )) {
                $list[] = $adminGrant->getName();
            }else{
                $list[] = $grantTag;
            }
        }
        return implode(',', $list);
    }

    public function hasPriv($urlKey){
        if( $this->grantTagList=='ALLGRANTS' ){
            return true;
        }
        else {
            $AdminUrls = array();
            $grantTagArray = $this->getGrantTagArray();
            $AdminGrants = AdminGrant::getAllGrant();
            foreach( $AdminGrants as $AdminGrant ) {
                if(in_array($AdminGrant->getTag(), $grantTagArray)) {
                    $AdminUrls[] = $AdminGrant->getUrl();
                }
            }
            return in_array($urlKey,$AdminUrls);
        }
    }

    public function hasTag($tagKey){
        if( $this->grantTagList=='ALLGRANTS' ){
            return true;
        }
        else {
            return in_array($tagKey,$this->getGrantTagArray());
        }
    }
    public function update($data){
        $keys= array();
        foreach ($data as $key => $value) {
            if( in_array($key,self::attributeColumns())&&$this->$key!=$value ) {
                $this->$key = $value;
                $keys[] = $key;
            }
        }
        $this->saveAttributes( $keys );
    }

    public function getTagList(){
        $grantTagArray = $this->getGrantTagArray();
        $list = [];
        foreach ($grantTagArray as $grantTag) {
            $tag = AdminGrant::multiLoadRow("tag = '$grantTag' and type = 2");
            if (!empty($tag)) {
                $list[$grantTag] = true;
            }
        }
        return $list;
    }


}