<?php
/**
 * Class RequestEvent
 * 时间锁机制
 *
 */
class RequestEvent{
    /**
     * RequestEvent::attackEventHandler()
     * 添加事件锁
     * @param mixed $app
     * @return 
     */
    public function attackEventHandler($app){
        $app->attachEventHandler('onBeginRequest', function($event) {
            if( $lockKey = RequestEvent::getLockKey() ){
                $lock = new EventLock;
                if( $lock->waitLock('RequestEvent', $lockKey) ) {
                    throw new CException('Request lock time out');
                }
            }
        });
        $app->attachEventHandler('onEndRequest', function($event) {
            if( $lockKey = RequestEvent::getLockKey() ){
                $lock = new EventLock;
                $lock->unlock('RequestEvent', $lockKey);
            }
        });
    }

    /**
     * RequestEvent::getLockKey()
     * 生成锁定的Key
     * @return
     */
    public static function getLockKey() {
        $session = Yii::$app->session;
        $session->open();
        if(isset($session['userId'])){
            $requestAction = empty($_REQUEST['r'])?'':$_REQUEST['r'];
            return $requestAction.$session['userId'];
        }
        else {
            return false ;
        }
    }
}
