<?php
namespace common\models;

use common\components\RecordModel;

class Moudle extends RecordModel {

    public static function primaryColumn(){
        return 'moudleId';
    }

    public static function addMoudle($data){
        //仅供简化使用，建议重写该方法
        return self::create($data);
    }


    public function getMoudleName(){
        return $this->moudleName;
    }


    public function getTableCols(){
        return $this->tableCols;
    }


    public function getShowCols(){
        return $this->showCols;
    }


    public function getPrimaryKey(){
        return $this->primaryKey;
    }


    public function getColsNames(){
        return $this->colsNames;
    }


    public function getColsTypes(){
        return $this->colsTypes;
    }

}
