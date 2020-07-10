<?php
namespace common\models;

use common\components\RecordModel;

class Demo extends RecordModel {

    public static function primaryColumn(){
        return 'demoId';
    }

    public static function addDemo($data){
        //仅供简化使用，建议重写该方法
        return self::create($data);
    }


    public function getName(){
        return $this->name;
    }


    public function getAge(){
        return $this->age;
    }


    public function getHome(){
        return $this->home;
    }


    public function getTelphone(){
        return $this->telphone;
    }


    public function getScore(){
        return '[EMPTY]';
    }

}
