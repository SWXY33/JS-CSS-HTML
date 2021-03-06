<?php
namespace console\jobs;

use yii\base\Object;

class BaseJob extends Object {
    protected $_attributes = array();

    public function __get($name)
    {
        if( isset($this->_attributes[$name]) ) {
            return $this->_attributes[$name];
        }
        else {
            return parent::__get($name); // TODO: Change the autogenerated stub
        }
    }

    public function __set($name, $value)
    {
        $this->_attributes[$name] = $value;
        //parent::__set($name, $value); // TODO: Change the autogenerated stub
    }
}