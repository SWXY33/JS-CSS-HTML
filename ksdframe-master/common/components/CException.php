<?php
/**
 * Class CException
 */
namespace common\components;

use yii\base\Exception;
class CException extends Exception{
    protected $params = array() ;

    public function __construct( $message, $code='-1', $params=array() ) {
        parent::__construct( $message, $code );
        $this->params = $params;
    }

    public function getParams() {
        return $this->params ;
    }

    public function getParam($name) {
        return isset($this->params[$name])?$this->params[$name]:false ;
    }

    public function getName() {
        return get_called_class();
    }
}
