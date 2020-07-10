<?php
/**
 * Created by PhpStorm.
 * User: zhaohe
 * Date: 2018/11/8
 * Time: 12:47 AM
 */

namespace common\models;

use common\components\RecordModel;
use common\components\Util;
use common\models\AdminModel;
use Yii;

class Param extends RecordModel {

    public static $dataKeys = array(
        'parentId','code','type','value','sortOrder',
    );

    public static function tableName(){
        return 'sysconfig';
    }

    public static function primaryColumn()
    {
        // TODO: Implement primaryColumn() method.
        return 'id';
    }

    public static function convertColumns(){
        return array(
            'parentId' => 'parent_id',
            'sortOrder' => 'sort_order',
        );
    }

    public static function add($userId,$day){
        $baseData = self::getUserDayData($userId,$day);
        return self::create(array_merge([
            'userId' => $userId,
            'day'    => $day,
        ],$baseData));
    }

    public function updateParamCode($value,$key){
        $paramLog = '管理员:['.AdminModel::getInstance()->getLoginUid().'],将['.$this->getName().']参数('.$key.')的值从'.$this->getValue().'修改为'.$value.'。（ip地址:'.Util::getRealIp().',设备信息:'.$_SERVER['HTTP_USER_AGENT'].'）';
        $this->value = $value;
        $this->log('系统参数修改',$paramLog);
        $this->event('updateParamCode','修改参数');
        return $this->saveAttributes(['value']);
    }

    public function updateParam($code,$value){
        $this->code = $code;
        $this->value = $value;
        return $this->saveAttributes(['code','value']);
    }

    public function getValue(){ 
        return $this->value;
    }

    public static function getConfig($code){

        $param = self::multiLoad(['code'=>$code]);
        if( !empty($param) ){
            return current($param)->getValue();
        }else{
            return false;
        }

    }
    

}

