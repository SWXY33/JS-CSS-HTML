<?php

namespace console\controllers;

use common\components\Util;
use common\models\ActivityModel;
use common\models\AMapModel;
use common\models\Card;
use common\models\CardModel;
use common\models\FeeLog;
use common\models\ReportDayModel;
use common\models\UserPayment;
use common\models\UserPaymentModel;
use common\models\JuheModel;
use common\models\UserModel;
use common\models\UserInvite;

class TestController extends BaseController {

    public function actionTest($a=1,$b=2){
        $this->message("a={$a} b={$b}");
        $this->message('Console Test Success.');
    }


    public function actionCdr(){
        $data = file_get_contents(dirname(__FILE__).'/../runtime/cdr.json');
        $obj = json_decode($data,true);

        $result = array();
        if(!empty($obj['variables']['direction']) && $obj['variables']['direction'] == 'outbound' && !empty($obj['callflow'][0])){
            $callflow=$obj['callflow'][0];
            //话机账号
            $result['deviceId'] = $callflow['caller_profile']['username'];
            //主叫学生卡账号
            $result['cardSn'] =$callflow['caller_profile']['caller_id_number'];

            //被叫家长手机号
            $result['phone']=substr($callflow['caller_profile']['destination_number'],4);
            $result['feeNo']=$obj['variables']['originating_leg_uuid'];
            //通话开始时间
            $result['beginTime']=$obj['variables']['start_epoch'];
            $result['endTime']=$obj['variables']['end_epoch'];
            //通话时长
            $result['talkTime']=$obj['variables']['billsec'];
        }
        //var_dump($result) ;
        $feeLog = FeeLog::add($result['cardSn'],$result['phone'],$result['beginTime'],$result['endTime'],$result['talkTime'],$result['deviceId'],$result['feeNo']);
        //$feeLog->doReduceFee();


        var_dump($feeLog->getFeeLogId());
    }

    public function actionGeo($lng='119.9772857',$lat='27.327578') {
        var_dump( json_encode(JuheModel::getInstance()->getGeoData($lng,$lat)) );
    }


    public function actionFeeReduce(){
        for($logId=1268306;$logId<=1274133;$logId++) {
            $feeLog = FeeLog::getInstance($logId);
            $feeLog->setFailed();
            var_dump($logId,$feeLog->doReduceFee());
            //break;

        }

    }

    public function actionActivity(){
        $cardId = 1000474;
        $money = 21;
        $chargeResult = Card::getInstance($cardId)->cardCharge(5,$money,'微信充值');

        if($chargeResult){
            ActivityModel::getInstance()->check('chargePresent',['money'=>$money,'cardId'=>$cardId]);
        }

    }


    public function actionReport(){
         $data = ReportDayModel::getInstance()->getSchoolDayData(308,'2020-01-14');
         var_dump($data);
    }


    public function actionAmap(){
        $result = AMapModel::getInstance()->getGeoByAddress('义堂中学东校区');
        var_dump($result);
        var_dump(AMapModel::getInstance()->getAddressByGeo($result['lng'],$result['lat']));
    }

}
