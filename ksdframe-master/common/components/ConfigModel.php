<?php
/**
 * Class ConfigModel
 * 通过配置文件的方式载入一组数据对象
 *
 * @author zhaohe
 * @version $Id$
 * @access public
 */

namespace common\components;
use yii;
use yii\base\Component;

abstract class ConfigModel extends Component {
    private $_attributes = array();
    private static $_configData = array();
    private $_id;
    
    /**
     * ConfigModel::getConfigName()
     * 获得当前配置名
     * 
     * @return string 对应的配置文件名
     */
    public static function getConfigName(){
        $classNameList = explode('\\',get_called_class());
        $className = end($classNameList);
        return lcfirst( $className );
    }
    
    /**
     * ConfigModel::__construct()
     * 构建配置数据对象
     * @param mixed $pk 主键
     * @return self
     * @throws CException
     */
    public function __construct($pk) {
        $configKey = static::getConfigName() ;
        self::loadConfigData($configKey);
        if (isset(self::$_configData[$configKey][$pk])) {
            $this->_id = $pk;
            $this->_attributes = self::$_configData[$configKey][$pk];
        }
        else {
            throw new CException('Config data not exists.');
        }
    }

    /**
     * 获取实例化对象
     * @param $primaryId
     * @return mixed
     */
    public static function getInstance( $primaryId ){
        try {
            $obj = Yii::$app->objectLoader->load( get_called_class(),$primaryId );
            return $obj;
        }
        catch( CException $e ) {
            return false;
        }
    }

    public function getId(){
        return $this->_id;
    }
    
    /**
     * 配置的所有属性
     * 
     * @return array
     */
    public function attributeNames() {
        return array_keys($this->_attributes);
    }
    
    /**
     * ConfigModel::__get()
     * 魔术方法用于获取对象的所有属性
     * @param mixed $name
     * @return void
     */
    public function __get($name) {
        if (in_array($name, $this->attributeNames())) {
            return $this->_attributes[$name];
        }
        else {
            return parent::__get($name);
        }
    }
    
    /**
     * ConfigModel::__set()
     * 魔术方法 重新设定属性值
     * 该类没有保存方法 所以设定都是临时改变，不会永久改变
     * @param mixed $name
     * @param mixed $value
     * @return void
     */
    public function __set($name, $value) {
        if (in_array($name, $this->attributeNames())) {
            $this->_attributes[$name] = $value;
        }
        else {
            parent::__set($name, $value);
        }
    }
    
    /**
     * ConfigModel::__isset()
     * 判断属性是否存在
     * @param mixed $name
     * @return Boolean 
     */
    public function __isset($name) {
        return isset($this->_attributes[$name]) ;
    }
    
    /**
     * ConfigModel::__unset()
     * 删除某个属性值 
     * 因为该类不涉及到保存功能 所以该值也是临时被删除
     * @param mixed $name
     * @return void
     */
    public function __unset($name) {
        unset($this->_attributes[$name]);
    }

    /**
     * @param string $name
     * @param array $args
     * @return mixed|void
     * @throws CException
     */
    public function __call($name,$args){
        if( strpos($name,'get')===0 ) {
            $key = lcfirst( str_replace('get','',$name) );
            if( isset($this->_attributes[$key]) ){
                return $this->$key;
            }
            else {
                throw new CException("method {$name} not exists.");
            }
        }
        else {
            return parent::__call($name,$args);
        }
    }
    /**
     * 判断记录是否存在
     * @return bool
     */
    public function isExists(){
        return !empty($this->_attributes)?true:false;
    }

    /**
     * 获取对象数据
     * @param array $keys
     * @return array
     */
    public function getDataArray( $keys=array() ){
        $result = array();
        if( !empty($keys) && is_array($keys) ) {
            foreach( $keys as $key ) {
                $temp = explode('|',$key);
                $key = $temp[0];
                $params = isset($temp[1])?explode(',',$temp[1]):array();
                $method = 'get'.ucwords($key);
                if( method_exists($this, $method) ) {
                    $result[$key] = call_user_func_array([$this, $method], $params);
                }
                else {
                    $result[$key]=$this->$key;
                }
            }
        }
        return $result ;
    }
    
    /**
     * ConfigModel::getMultiData()
     * 获取多个对象
     * @param mixed $params 条件数组
     * @param string $configKey 主键，对应的配置文件名字
     * @return 所有数据对象 
     */
    protected static function getMultiData( $params=array(),$configKey='' ){
        if( empty($configKey) ) {
            $configKey = static::getConfigName() ;
        }
        self::loadConfigData($configKey);
        $dataArray = array();
        foreach( self::$_configData[$configKey] as $key=>$rowData ) {
            $isContinue = false ;
            foreach ($params as $k=>$v) {
                if( $rowData[$k]!=$v ) {
                    $isContinue = true ;
                    break ; 
                }
            }
            if( $isContinue ) {
                continue ;
            }
            $dataArray[$key] = Yii::$app->objectLoader->load(get_called_class(),$key);
        }
        return $dataArray ;
    }
    
    /**
     * ConfigModel::loadConfigData()
     * 从配置文件中载入配置对象
     * 
     * @param mixed $configKey 主键，对应的配置文件名字
     * @return array 所有数据数组
     */
    private static function loadConfigData($configKey){
        if( !isset(self::$_configData[$configKey]) ) {
            self::$_configData[$configKey] = Util::loadconfig( $configKey );
        }
    }
    
}

