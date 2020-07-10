<?php
/**
 * 基础数据类 RecordModel
 * 
 * @author zhaohe
 *
 */
namespace common\components;

use common\models\MetaEvent;
use Yii;
use yii\base\Component;
use common\models\MetaLog;

abstract class RecordModel extends Component implements RecordInterface {
    private $_attributes = array();
    private $primaryId;
    protected static $convertCols = array();
    protected static $rowCache = false;
    protected static $rowCacheTime = 60;
    protected static $tableCacheTime = 180;

    public function __construct($primaryId) {
        $this->primaryId=$primaryId;
        $this->recordInit();
    } 

    protected function recordInit(){
        //类变量、方法、逻辑初始化函数 子类重写该方法即可
    }

    protected static function realColumn($name) {
    $convertCols=static::convertColumns();
    return !empty($convertCols[$name])?$convertCols[$name]:$name;
}

    public static function tableName(){
        $classNameList = explode('\\',get_called_class());
        $className = end($classNameList);
        return lcfirst( $className );
    }
    public static function attributeColumns(){
        return self::tableCols();
    }

    public static function convertColumns(){
        return array();
    }

    /**
     * 获取实例化对象
     * @param $primaryId
     * @throws CException
     * @return mixed
     */
    public static function getInstance( $primaryId ){
        if( empty($primaryId) ) {
            throw new CException('Empty primary key ['.get_called_class().':'.$primaryId.']');
        }
        return Yii::$app->objectLoader->load( get_called_class(),$primaryId );
    }

    /**
     *  载入数据和保存数据的两个基础方法
     *  如果类的操作逻辑不同重载这两个方法即可
     */
    /**
     * @return mixed
     *
     */
    protected function loadData(){
        $indexCol = static::primaryColumn();
        $tableName = static::tableName();
        static $data = array();
        $dataKey = $tableName.'_'.$this->$indexCol;
        if( !isset($data[$dataKey]) ) {
            if( self::$rowCache ){
                $data[$dataKey] = self::cache($dataKey);
            }
            if( empty($data[$dataKey]) ) {
                $indexCol = self::realColumn($indexCol);
                $sql = "select * from `$tableName` where $indexCol='{$this->$indexCol}' and deleteFlag=0 limit 1";
                $data[$dataKey] =  Yii::$app->db->createCommand($sql)->queryOne();
                self::cache($dataKey,$data[$dataKey],self::$rowCacheTime);
            }
        }
        return $data[$dataKey] ;
    }
    protected function saveData($attributes=array()){
        $indexCol = static::primaryColumn();
        $tableName = static::tableName();
        return DbUtil::update(Yii::$app->db,$tableName, $attributes, array($indexCol=>$this->$indexCol)) ;
    }

    public function getTableName(){
        return lcfirst(__CLASS__);
    }

     /**
      * 返回当前类允许的列名
      **/
    public function attributeNames(){
        return static::attributeColumns();
    }


    /**
     * 获得属性的魔术方法
     * @param string $name 属性名
     * @return mixed|null
     * @throws CException
     */
    public function __get($name) {
        $name = self::realColumn($name);
        if( $name==static::primaryColumn() ){
            return $this->primaryId;
        }
        elseif (in_array($name, $this->attributeNames())) {
            if (array_key_exists($name, $this->_attributes)) {
                return $this->_attributes[$name];
            }
            else {
                $rowData = $this->loadData();
                if ( empty($rowData) ) {
                    //throw new CException('Data record not exists.');
                    return null;
                }
                else {
                    $this->loadRecord($rowData);
                }
                
                if (array_key_exists($name, $this->_attributes)) {
                    return $this->_attributes[$name];
                }
                else {
                    return null;
                }
            }
        }
        else {
            return parent::__get($name);
        }
    }

    /**
     * @param string $name
     * @param array $args
     * @return mixed|null
     * @throws CException
     */
    public function __call($name,$args){
        if( strpos($name,'get')===0 ) {
            $key = self::realColumn(  lcfirst( str_replace('get','',$name) ) );
            if( in_array($key,$this->attributeNames()) ){
                return $this->$key;
            }
            else {
                throw new CException("method {$name} not exists.");
            }
        }
        else {
            parent::__call($name,$args);
        }
    }
    
    public function loadRecord($rowData) {
        foreach ($this->attributeNames() as $attributeName) {
            if (!array_key_exists($attributeName, $this->_attributes)) {
                if (isset($rowData[$attributeName])) {
                    $this->_attributes[$attributeName] = $rowData[$attributeName];
                }
                else {
                    $this->_attributes[$attributeName] = null;
                }
            }
        }
    }

    /**
     * 获取对象数据
     * @param array $keys
     * @return array
     *
     */
    public function getDataArray( $keys=array() ){
        $result = array();
        if( !empty($keys) && is_array($keys) ) {
            //$keys[] = 'dateTime';
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
     * 获取记录的创建时间
     */
    public function getDateTime(){
        return date('Y-m-d H:i:s',$this->createTime);
    }

    /**
     * 根据sql语句批量载入数据对象
     * 只给继承的类内部调用 
     * 
     * @param string $sql sql语句
     * @param string $indexCol 用于数据索引的字段名
     * @param array    $params DBCommand对象绑定的数据类型
     * @param boolean $isSimple 是否是简单数据类型
     *
     * @return array 返回载入成功的数据对象集合 以indexCol指定的字段为索引
     */
     protected static function multiLoadBySql( $sql,$indexCol='',$params=array(),$isSimple=false ){
         static $sqlData = array(); //同样的sql在同一逻辑中只执行一次
         $key = md5($sql);
         if(empty($indexCol)) {
            $indexCol = static::primaryColumn();
         }
         else {
            $indexCol = static::realColumn($indexCol);
         }
         if( empty($sqlData[$key]) ) {
             $command = Yii::$app->db->createCommand( $sql );
             $result = $command->bindValues($params)->queryAll();
             $sqlData[$key] = array();
             foreach (  $result as $i=>$row ) {
                 $index = isset($row[$indexCol])?$row[$indexCol]:$i ;
                 if( $isSimple ) {
                     $dataArray[$index] = new stdClass();
                     foreach( static::attributeColumns() as $key ) {
                         $sqlData[$key][$index]->$key = $row[$key] ;
                     }
                     if( self::$rowCache ) {
                        $dataKey = self::tableName().'_'.$row[$indexCol];
                        self::cache($dataKey,$row,self::$rowCacheTime);
                     }
                 }
                 else {
                     $sqlData[$key][$index] = Yii::$app->objectLoader->load( get_called_class(),$row[$indexCol] );
                     $sqlData[$key][$index] -> loadRecord($row);
                 }
             }
         }
         return $sqlData[$key];
     }

    /**
     * 设置字段属性值
     * @param string $name
     * @param mixed $value
     * @return mixed|void
     */
    public function __set($name, $value) {
        $name = self::realColumn($name);
        if (in_array($name, $this->attributeNames())) {
            $this->_attributes[$name] = $value;
        }
        else {
            parent::__set($name, $value);
        }
    }

    /**
     * 魔术方法
     * 
     * @param string $name
     * @return bool
     */
    public function __isset($name) {
        try{
            $value = $this->__get($name);
        } catch (\Exception $e) {
            return false;
        }
        
        if (isset($value)||isset($this->_attributes[$name])) {
            return true;
        }
        else {
            return parent::__isset($name);
        }
    }
    
    public function __unset($name) {
        unset($this->_attributes[$name]);
    }

    /**
     * 保存数据项
     * 
     * @param array $attributeNames
     * @return bool
     */
    public function saveAttributes($attributeNames=array()) {
        if( !is_array($attributeNames) ){
            $attributeNames = explode(',',$attributeNames);
        }
        $saveAttributes = array();
        foreach ($attributeNames as $attributeName) {
            $attributeName = static::realColumn($attributeName);
            if (in_array($attributeName, $this->attributeNames())){
                $saveAttributes[$attributeName] = $this->_attributes[$attributeName];
            }
        }
        return $this->save($saveAttributes);
    }
    
    private function save($attributes = array()) {
        return $this->saveData($attributes);
    }
    
    public function reset() {
        $this->_attributes = array();
    }

    /**
     * 标记删除记录
     * 
     * @return void
     */
    public function delete(){
        $indexCol = static::realColumn(static::primaryColumn());
        $this->deleteFlag = 1;
        $this->saveAttributes(array('deleteFlag'));
        $this->reset();
        $this->log('delete record:table['.static::tableName().'],index['.$this->$indexCol.']',json_encode($_SERVER));
        return true;
    }

    /**
     * 判断数据对象是否存在
     * @return bool
     */
    public function isExists() {
        $attributeNames = $this->attributeNames();
        $firstKey = current($attributeNames);
        $endKey = end($attributeNames);
        try{
            return isset( $this->$firstKey )&&isset( $this->$endKey ) ;
        } catch (Exception $e) {
            return false ;
        }
    }

    /**
     * 通用日志记录逻辑
     *
     * @param $logMessage
     * @param string $logDetail
     * @return mixed
     */
    public function log($logMessage,$logDetail=''){
        return MetaLog::add($logMessage,$logDetail,self::tableName(),$this->primaryId);
    }

    /**
     * 通用事件记录逻辑
     *
     * @param string $eventKey
     * @param string $eventContent
     * @param string $eventDetail
     * @return mixed
     */
    public function event($eventKey,$eventContent,$eventDetail=''){
        return MetaEvent::add($eventKey,$eventContent,$eventDetail,get_called_class(),$this->primaryId);
    }

    /**
     * 获取当前表结构
     *
     * @return array 表字段名构成的数组
     */
    public static function tableCols(){
        static $dbCols = array();
        $tableKey = 'TABLE_COLS_'.static::tableName();
        if( !isset($dbCols[$tableKey]) ) {
            $cols = self::cache($tableKey);
            if( empty($cols) ) {
                $cols = DbUtil::getTableCols( static::tableName() );
            }
            $dbCols[$tableKey] = $cols;
        }
        return $dbCols[$tableKey];
    }

    //public static function

    public static function getTableColsArray(){
        return DbUtil::getTableColsArray( static::tableName(),array(static::primaryColumn()) );
    }

    /**
     * @param array $params
     * @param string $field
     * @return string
     */
    public static function getMultiSql(&$params=array(), $field='*' ){
        $sql = "SELECT {$field} FROM `".static::tableName()."` WHERE deleteFlag=0 ";
        if( empty($params) ){
            return $sql;
        }
        if( is_array($params) ) {
            foreach( $params as $k=>$v ){
                $v = addslashes($v);
                if( $k===intval($k) ) {
                    $sql .= ' and ' .$k;
                }
                else {
                    $sql .= " and {$k}='{$v}'";
                }
            }
        }
        else {
            $sql .= ' and ('.$params.')' ;
        }
        return $sql;
    }
    
    public static function getRecordCount($params=array()){
        static $countResult = array();
        $sql = self::getMultiSql($params,'count(*) as recordCount');
        $key = md5($sql);
        if( !isset($countResult[$key]) ) {
            $result = Yii::$app->db->createCommand($sql)->queryOne();
            $countResult[$key] = $result['recordCount'];
        }
        return $countResult[$key];
    }

    public static function multiLoad( $params=array(),$orderBy='',$limit='',$fields='*',$indexCol='' ){

        if( empty($indexCol) ){
            $indexCol = static::primaryColumn();
        }
        $sql = self::getMultiSql( $params,$fields );
        if( !empty($orderBy) ) {
            $sql .= " ORDER BY ".$orderBy;
        }
        else {
            $sql .= " ORDER BY ".static::primaryColumn().' DESC';
        }
        if( !empty($limit) ) {
            $sql .= " LIMIT ".$limit;
        }
        return self::multiLoadBySql($sql,$indexCol,array(),false);
    }

    public static function multiLoadRow( $params=array() ){

        $list = self::multiLoad( $params,'','0,1');
        return !empty($list)?current($list):'';
        
    }

    public static function getCount($params){

        $sql = self::getMultiSql( $params,'count(*) as num' );
        $command = Yii::$app->db->createCommand( $sql );
        $result = $command->queryAll();
        $result = reset($result);
        return intval($result['num']);

    }

    public static function getSum($params,$value){

        $sql = self::getMultiSql( $params,'sum('.$value.') as valueSum' );
        $command = Yii::$app->db->createCommand( $sql );
        $result = $command->queryAll();
        $result = reset($result);
        return intval($result['valueSum']);

    }


    /**
     * 创建记录
     *
     **/
    public static function create($createInfo)
    {
        $data = array();
        foreach (static::attributeColumns() as $key) {
            if (isset($createInfo[$key])) {
                $data[$key] = $createInfo[$key];
            }
        }
        if (is_array(static::convertColumns())) {
           foreach (static::convertColumns() as $key=>$val) {
                if (isset($createInfo[$key])) {
                    $data[$val] = $createInfo[$key];
                }
            }
        }
        $data['createTime'] = time();
        $insertId = DbUtil::insert(Yii::$app->db,static::tableName(), $data, true) ;
        $primaryKey = static::primaryColumn();
        if( !empty($createInfo[$primaryKey]) ){
            $insertId = $createInfo[$primaryKey];
        }
        return Yii::$app->objectLoader->load(get_called_class(), $insertId);
    }

    // 更新字段
    public function update($data){
        $keys= array();
        foreach ($data as $key => $value) {
            if( in_array($key,self::attributeColumns())&&$this->$key!=$value ) {
                $this->$key = $value;
                $keys[] = $key;
            }
        }
        $this->saveAttributes( $keys );
    }


    /**
     * 获取/设置缓存数据
     *  
     * @param string $key 缓存索引
     * @param mixed  $vlaue 要设置的值 取数据请留空此值
     * 
     * @return true / cache data
     */
    public static function cache($key,$value=KEY_NOT_SET_VALUE,$time=180){
        $key = self::getCacheKey($key);
        if( $value==KEY_NOT_SET_VALUE ){
            return Yii::$app->cache->get($key) ;
        }
        else {
            Yii::$app->cache->set($key, $value,$time);
            return true ;
        }
    }

    /**
     * 清除所有缓存 
     * 
     *  @return void 
     */
    public static function flushCache(){
        Yii::$app->cache->flush();
    }

    /**
     * 处理缓存的key值 自动拼合当前的类名 避免不同类key重复问题
     * @params string $key
     */
    protected static function getCacheKey($key){
        return get_called_class() . '_' . $key;
    }


}
