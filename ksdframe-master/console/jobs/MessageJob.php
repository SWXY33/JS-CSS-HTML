<?php
namespace console\jobs;


use common\models\QueueModel;
use common\models\SendMessage;
use common\models\User;
use common\models\UserOrderModel;
use Yii;
use yii\queue\Job;

class MessageJob extends BaseJob implements Job{

    public function execute($queue)
    {
        // TODO: Implement execute() method.
        switch ($this->type){
            case 'allUser':
                $this->sendAllUser($this->messageId);
                break;
            case 'selecteUser':
                $this->sendSelecteUser($this->messageId, $this->sendUser);
                break;
            default:
                //do nothing
        }
    }

    public function sendAllUser($messageId){
        $userList = User::multiLoad(['deleteFlag'=>0]);
        foreach($userList as $user){
            $createData = [
                'messageId'=>$messageId,
                'receiverUserId'=>$user->userId,
                'sentTime'=>time(),
                'createTime'=>time(),
            ];
            SendMessage::add($createData);
        }
    }

    public function sendSelecteUser($messageId, $sendUser){
        $sendUserArr = explode(',',$sendUser);

        foreach($sendUserArr as $mobile){
            $user = User::multiLoad(['mobile'=>$mobile]);
            if($user){
                $createData = [
                    'messageId'=>$messageId,
                    'receiverUserId'=>$user->userId,
                    'sentTime'=>time(),
                    'createTime'=>time(),
                ];
                SendMessage::add($createData);
            }
        }
    }

}