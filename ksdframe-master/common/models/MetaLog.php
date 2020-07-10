<?php
/**
 *  数据库日志基础类.
 * User: zhaohe
 */
namespace common\models;

use \common\components\RecordModel;

class MetaLog extends RecordModel {

    public static function primaryColumn(){
        return 'logId';
    }


    /**
     * 添加日志
     * 
     * @param mixed $logMessage 日志内容，比较易读的格式
     * @param string $logDetail 详细情况，可以是sql、事件等具体数据打包
     * @param string $logTable 关联的数据表
     * @param string $relativeId 关联的主键id
     * @param string $actionUserId 操作人员
     * @param string $actionUserName 操作的用户名
     * @return object 刚刚插入的日志对象
     */
    public static function add( $logMessage,$logDetail='',$logTable='',$relativeId='0',$actionUserId='0',$actionUserName='' ) {
        /*
        if( empty($actionUserId)) {
            $actionUserId = UserModel::getLoginUid();
        };
        if( empty($actionUserName) ){
            $actionUserName = UserModel::getLoginUser()->getUsername();
        }
        */
        $obj = static::create( array(
            'logMessage'=>$logMessage,
            'logDetail'=>$logDetail,
            'logTable'=>$logTable,
            'relativeId'=>$relativeId,
            'actionUserId'=>$actionUserId,
            'actionUserName'=>$actionUserName,
        ) );
        return $obj;
    }


} 