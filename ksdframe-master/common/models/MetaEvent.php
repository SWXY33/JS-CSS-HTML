<?php
/**
 * 事件基础类.
 * User: zhaohe
 */
namespace common\models;

use \common\components\RecordModel;

class MetaEvent extends RecordModel {

    public static function primaryColumn(){
        return 'eventId';
    }


    /**
     * 添加日志
     *
     * @param mixed $eventKey 日志内容，比较易读的格式
     * @param mixed $eventContent 日志内容，比较易读的格式
     * @param string $eventDetail 详细情况，可以是sql、事件等具体数据打包
     * @param string $relativeClass 关联的数据表
     * @param string $relativeId 关联的主键id
     * @return object 刚刚插入的事件对象
     */
    public static function add( $eventKey,$eventContent,$eventDetail='',$relativeClass='',$relativeId='0' ) {
        $obj = static::create( array(
            'eventKey'=>$eventKey,
            'eventContent'=>$eventContent,
            'eventDetail'=>$eventDetail,
            'relativeClass'=>$relativeClass,
            'relativeId'=>$relativeId,
        ) );
        return $obj;
    }

} 