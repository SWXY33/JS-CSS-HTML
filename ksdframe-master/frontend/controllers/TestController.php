<?php

namespace frontend\controllers;

use common\models\StudentModel;
use common\models\Student;
use common\models\Staff;
use common\models\StaffModel;
use common\models\StudentClassModel;
use common\models\AttendanceModel;
use common\models\RouteModel;
use common\models\StudentLogModel;
use common\models\CarLogModel;
use common\models\TrajectoryModel;
use common\models\UserModel;
use common\models\CardModel;
use common\components\SException;
use common\components\WxAppPay;
use Yii;

class TestController extends BaseController{

    public function actionAddChargeOrder(){
        try {
            $uuid = 'ocDGg53gi6Oi1PLCkljRSlTsClgU';
            $data = UserModel::getInstance()->addChargeOrder($uuid);
            $this->displayData($data);
        }
        catch (SException $e) {
            $this->error($e->getMessage());
        }
    }

    public function actionDoCharge(){
        try {
            $param = array(
                'cardnum' => '538000701',
                'fee' => 10,
                'orderid' => '202001101704045023111',
                'uuid' => 'ocDGg53gi6Oi1PLCkljRSlTsClgU',
            );
            $data = UserModel::getInstance()->doCharge($param['cardnum'],$param['fee'],$param['orderid'],$param['uuid']);
            $this->displayData($data);
        }
        catch (SException $e) {
            $this->error($e->getMessage());
        }
    }

    public function actionGetChargeLog(){
        try {
            $cardNumber = '5399933232';
            $data = UserModel::getInstance()->getChargeLog($cardNumber);
            $this->displayData($data);
        }
        catch (SException $e) {
            $this->error($e->getMessage());
        }
    }

    public function actionCheckTalkAccess(){
        try {
            $cardNumber = '538000701';
            $phone = "18654581902";
            $card = CardModel::getInstance()->getCardByNumber($cardNumber);
            $data = $card->checkTalkAccess($phone);
            $this->displayData($data);
        }
        catch (SException $e) {
            $this->error($e->getMessage());
        }
    }

}
