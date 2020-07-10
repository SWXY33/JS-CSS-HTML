<?php
namespace common\models;


use Yii;
use common\components\Model;
use console\jobs\EmailJob;
use console\jobs\OrderJob;
use console\jobs\MessageJob;

class QueueModel extends Model {

    public function pushEmail($type,$relativeId,$data=array()){
        $queueId = Yii::$app->queue->push( new EmailJob([
            'type' => $type,
            'relativeId' => $relativeId,
            'data' => $data,
        ]) );
        //log queue job add
        //return job id
        return $queueId;
    }

    public function pushOrder($type,$orderId,$data=array()){
        $queueId = Yii::$app->queue->push( new OrderJob([
            'type' => $type,
            'orderId' => $orderId,
            'data' => $data,
        ]) );
        //log queue job add
        //return job id
        return $queueId;
    }

    public function pushMessage($sendUser,$messageId){
        if($sendUser == 0){
            $type = 'allUser';
        }elseif(strlen($sendUser) >= 11){
            $type = 'selecteUser';
        }else{
            //do nothing
        }

        $queueId = Yii::$app->queue->push( new MessageJob([
            'type' => $type,
            'sendUser' => $sendUser,
            'messageId' => $messageId,
        ]));

        return $queueId;
    }

    public function pushUser($type,$relativeId,$data=array()){

        $queueId = Yii::$app->queue->push( new EmailJob([
            'type' => $type,
            'relativeId' => $relativeId,
            'data' => $data,
        ]) );
        //log queue job add
        //return job id
        return $queueId;
        
    }

}

