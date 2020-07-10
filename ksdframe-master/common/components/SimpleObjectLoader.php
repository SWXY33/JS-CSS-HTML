<?php
/**
 * Class SimpleObjectLoader
 * 简易数据对象管理类
 * 所有进程/内存中的对象都通过该类类获取存储，保证类的单一和唯一性确保数据的准确
 *
 */
namespace common\components;

use Yii;
use yii\base\Component;

class SimpleObjectLoader extends Component{
    private $_attribute;
    
    /**
     * SimpleObjectLoader::__construct()
     * 
     * @return
     */
    public function __construct(){
        $this->_attribute = array();
    }

    /**
     * SimpleObjectLoader::init()
     * 
     * @return
     */
    public function init(){
        parent::init();
    }
    
    /**
     * SimpleObjectLoader::load()
     * 
     * @param mixed $objectName
     * @param integer $uniqueId
     * @return
     */
    public function load($objectName, $uniqueId = 0){
        if( !($object = $this->get($objectName, $uniqueId)) ){
            if( empty($uniqueId) ) {
                $object = new $objectName ;
            }
            else {
                $object = new $objectName($uniqueId);
            }
            $this->set($objectName, $uniqueId, $object);
        }
        return $object;
    }
    
    /**
     * SimpleObjectLoader::get()
     * 
     * @param mixed $objectName
     * @param mixed $uniqueId
     * @return
     */
    public function get($objectName, $uniqueId){
        if(isset($this->_attribute[$objectName][$uniqueId])){
            return $this->_attribute[$objectName][$uniqueId];
        }
        return null;
    }

    /**
     * SimpleObjectLoader::set()
     * 
     * @param mixed $objectName
     * @param mixed $uniqueId
     * @param mixed $object
     * @return
     */
    public function set($objectName, $uniqueId, $object){
        return $this->_attribute[$objectName][$uniqueId] = $object;
    }
}