<?php
namespace common\components;

/**
 * 事件锁
 * 用法 ：$eventLock = new EventLock() ;
 *       
 *        $eventLock->getLock($name,$key) ;
 *        $eventLock->unlock($name,$key);
 */
class EventLock{
    private $_prefix = 'EventLock_';
    private $_timeout = 10;

    /**
     * 获取时间锁
     *
     * @param $name
     * @param $key
     * @param int $expire
     * @return bool
     */
    public function getLock($name, $key, $expire = 10){
        if(Yii::$app->cache->add($this->_prefix.$name.$key, @getmypid(), $expire)){
            return true;
        }
        return false;
    }

    /**
     * 获取等待锁定
     *
     * @param $name
     * @param $key
     * @param int $expire
     * @return bool
     */
    public function waitLock($name, $key, $expire = 10){
        $waitTime = 0;
        while(!Yii::$app->cache->add($this->_prefix.$name.$key, @getmypid(), $expire)){
            if($waitTime < $this->_timeout){
                usleep(10000);
                $waitTime += 0.01;
            }else{
                return true;
            }
        }
        return false;
    }

    /**
     * 释放锁
     * @param $name
     * @param $key
     */
    public function unlock($name, $key){
        Yii::$app->cache->delete($this->_prefix.$name.$key);
    }
}

