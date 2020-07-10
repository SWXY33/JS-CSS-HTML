<?php
/**
 * 
 * User: PHPStorm
 * Date: 2017/12/2
 */

namespace common\models;


use common\components\CException;
use common\components\RecordModel;
use common\components\Util;

class Sms extends RecordModel
{

    public static function primaryColumn()
    {
        // TODO: Implement primaryColumn() method.
        return 'smsId';
    }

    public static function addAuthcode($mobile,$authCode) {
        $data = array('app'=>CONFIG('shop_name'),'code'=>$authCode,'templateId'=>CONFIG('juhe_sms_template_id'));
        return self::add($mobile,$data);
    }

    private static function add($mobile,$data,$sendTime=0){
        if( empty($sendTime) ) $sendTime = time();
        $data = array(
            'mobile' => $mobile,
            'sendData' => json_encode($data),
            'sendTime' => $sendTime,
            'userIp'   => Util::getRealIp(),
            'userAgent' => $_SERVER['HTTP_USER_AGENT']
        );
        return self::create($data);
    }

    public function getSendData(){
        return json_decode( $this->sendData,true );
    }

    /**
     * 发送当前的短信
     *
     */
    public function send(){
        try {
            $sendResult = JuheModel::getInstance()->sendAuthCodeSms($this->mobile,$this->getSendData());
            $this->sendFlag = 1;
            $this->resultData = json_encode($sendResult);
        }
        catch(CException $e) {
            $this->sendFlag = -1;
            $this->resultData = $e->getMessage();
        }
        $this->resultTime = time();
        return $this->saveAttributes( array('sendFlag','resultTime','resultData') );
    }

}