<?php
namespace common\models;

use common\components\RecordModel;

class Apple extends RecordModel {

    public static function primaryColumn(){
        return 'appleId';
    }

    public static function addApple($data){
        //仅供简化使用，建议重写该方法
        return self::create($data);
    }


    public function getName(){
        return $this->name;
    }


    public function getColor(){
        return $this->color;
    }


    public function getPrice(){
        return $this->price;
    }


    public function getWeight(){
        return $this->weight;
    }

}
