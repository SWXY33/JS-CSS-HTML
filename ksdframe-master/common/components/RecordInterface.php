<?php
/**
 * RecordModel类绑定的接口方法
 * 
 * @author user
 *
 */
namespace common\components;

Interface RecordInterface {

    //static function tableName(); //recordmodel中实现 如需调整重载即可

    static function primaryColumn();


    /**
     * 静态方法 返回一个允许使用的属性的列表数组
     *
     * @return array
     */
    //static function attributeColumns();

    /**
     * 属性字段对应关系
     *
     * @return array
     */
    //static function convertColumns();

    /**
     * 静态方法 返回一堆对象的数组
     * 
     * @param array $params 条件参数 根据具体情况自行定义
     * @param boolean $isSimple 是否是简易数据类型
     */
    //static function multiLoad( $params=array(),$isSimple=true );
} 

