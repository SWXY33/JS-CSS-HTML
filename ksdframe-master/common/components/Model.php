<?php
namespace common\components;
use common\models\MetaEvent;
use common\models\Zone;
use Yii;

class Model extends \yii\base\Model {

    private static $_instance = array();

    /**
     * 获得当前类的实例
     * @return Object
     */
    public static function getInstance(){
        $className = get_called_class();
        if( empty(self::$_instance[$className]) || !self::$_instance[$className] instanceof self) {
            self::$_instance[$className] = new $className;
        }
        return self::$_instance[$className];
    }


    /**
     * 获取/设置缓存数据
     *  
     * @param string $key 缓存索引
     * @param mixed  $vlaue 要设置的值 取数据请留空此值
     * 
     * @return true / cache data
     */
    public function cache($key,$value=KEY_NOT_SET_VALUE,$time=180){
        $key = $this->getCacheKey($key);
        if( $value==KEY_NOT_SET_VALUE ){
            return Yii::$app->cache->get($key) ;
        }
        else {
            Yii::$app->cache->set($key, $value, $time);
            return true ;
        }
    }

    /**
     * 清除所有缓存 
     * 
     *  @return void 
     */
    public function flushCache(){
        Yii::$app->cache->flush();
    }

    /**
     * 处理缓存的key值 自动拼合当前的类名 避免不同类key重复问题
     *
     * @param string $key
     * @return string $cachekey
     */
    protected function getCacheKey($key){
        return get_class($this) . '_' . $key;
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
        return MetaEvent::add($eventKey,$eventContent,$eventDetail,get_called_class());
    }

    // 获取搜索条件
    public function getSearchCondition($searchData=array()){

        $condition = '1';
        if (!empty($searchData)) {
            foreach ($searchData as $key => $searchValue) {
                if (!empty($searchValue)) {
                    if ($key == 'dateTime') {
                        $startDate = time($searchValue[0]);
                        $endDate = time($searchValue[1]);
                        $condition .=" AND createTime >= '$startDate' AND createTime <= '$endDate'";
                    } elseif ($key == 'selectZoneList'){

                        //添加判断代理商的区域问题
                        $zoneId = !empty($searchData['selectZoneList'])?array_slice($searchData['selectZoneList'],-1,1):'0';
                        $schoolIdList = Zone::getInstance($zoneId[0])->getZoneSchoolListString();
                        if (!empty($schoolIdList)) {
                            $condition .= " AND schoolId in($schoolIdList)";
                        }

                    }else{
                        $condition .=" AND $key = '$searchValue' ";
                    }
                   
                }
            }
        }
        return $condition;

    }

}

