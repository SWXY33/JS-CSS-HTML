<?php

namespace common\models;

use Yii;
use common\components\Model;
use common\components\SException;


class MessageModel extends Model{

    public static $dataKeys = array(
        'messageId','sendUser','title','content','isSend','createTime'
    );

    public static function addMessage($sendUser,$type,$mobile,$title,$content){

        $data = array(
            'sendUser' => $sendUser,
            'type' => $type,
            'title' => $title,
            'mobile' => $mobile,
            'content' => $content,
            'isSend' => 0,
            'createTime' => time(),
        );

        return Message::create($data);

    }

    public function getMessageParams($keytype,$keyword,$isSend,$startDateRange = ''){//根据条件对应查询
        $conditions = '1';

        if(!empty($keyword)){
            if ($keytype=='title'){
                $conditions .= " AND title like '%$keyword%'";
            }else if ($keytype=='content'){
                $conditions .= " AND content like '%$keyword%'";
            }else{
                //do nothing
            }
        }

        if(!empty($isSend) || $isSend == '0'){
            $conditions .= " AND isSend = '$isSend'";
        }

        if($startDateRange != ''){
            $startDate = mb_substr($startDateRange,0,19);
            $endDate = mb_substr($startDateRange,-19);

            $TimeBegin = strtotime($startDate);
            $TimeEnd = strtotime($endDate);

            $conditions .= " AND createTime > " . $TimeBegin;
            $conditions .= " AND createTime < " . $TimeEnd;
        }

        return $conditions;
    }

    /**
     * 获取消息列表
     * @return array
     */
    public function getMessageList($limit,$params){
        $goodsList = Message::multiLoad($params,'messageId desc',$limit);

        $list = array();
        foreach($goodsList as $goods) {
            $goods->isSend = $goods->isSend == 0 ? '未发送' : '已发送';
            $list[] = $goods->getDataArray(self::$dataKeys);
        }

        $data = array();
        $data['list'] = $list;
        $data['total'] = intval(Message::getRecordCount($params));

        return $data;
    }

    public function getTopUpInfo($messageId){
        $messageInfo = Message::getInstance($messageId)->getDataArray(self::$dataKeys);
        return $messageInfo;
    }

    public function changeMessage($messageId,$sendUser,$title,$content,$isSend){
        if(empty($messageId)|| (empty($sendUser) && $sendUser != '0') || empty($title) || empty($content) || (empty($isSend) && $isSend != '0')) {
            throw new SException('参数不能为空');
        }

        if(mb_strlen($sendUser) > 11){
            //判断中英文逗号
            if(empty(mb_strpos($sendUser,',')) && empty(mb_strpos($sendUser,'，'))){
                throw new SException('指定用户,请使用逗号分隔');
            }elseif(!empty(mb_strpos($sendUser,'，'))){ //中文逗号
                $sendUser_ZN_Arr = explode($sendUser,'，');
                $sendUser = implode($sendUser_ZN_Arr,',');
            }else{
                //do nothing
            }
        }elseif($sendUser != 0 && mb_strlen($sendUser) !== 11){
            throw new SException('用户名错误');
        }else{
            //do nothing
        }

        if(Message::getInstance($messageId)->getIsSend() == 1){
            throw new SException('消息已发送,不允许修改');
        }

        $message = Message::getInstance($messageId)->updateMessage($title,$sendUser,$content,$isSend);

        self::sendMessage($sendUser,$messageId);

        return $message;
    }

    public static function sendMessage($sendUser,$messageId){
        QueueModel::getInstance()->pushMessage($sendUser,$messageId);
        return true;
    }

}
