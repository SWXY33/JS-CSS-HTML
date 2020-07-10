<?php

namespace frontend\controllers;

use common\components\Util;
use common\components\SException;
use common\models\StudentModel;
use common\models\Student;
use common\models\Staff;
use common\models\StaffModel;
use common\models\StudentClassModel;
use common\models\AttendanceModel;
use common\models\RouteModel;
use common\models\DeviceModel;
use common\components\WxAppPay;
use Yii;

class IndexController extends BaseController
{
    public $layout = "frontend"; 

    public function actionIndex(){
        exit('Page Not Found!');
    }

    public function actionJsData(){
        $amountTypeList = AmountType::getAll();
        $causeTypeList = CauseType::getAll();
        $productList = Product::getAll();
        $appData = array(
            'amountTypeList' => $this->_config_to_js($amountTypeList,'id','name'),
            'causeTypeList' => $this->_config_to_js($causeTypeList,'id','name'),
            'productList' => $this->_config_to_js($productList,'productId','productName'),
        );
        //附加数据
        header('Content-type:text/javascript');
        echo "var AppData = ".json_encode($appData);
        exit;
    }

    private function _config_to_js($list,$valueKey,$labelKey){
        $result = array();
        $valueMethod = 'get'.$valueKey;
        $labelMethod = 'get'.$labelKey;
        foreach( $list as $obj ){
            $result[] = array(
                'value' => $obj->$valueMethod(),
                'label' => $obj->$labelMethod(),
            );
        }
        return $result;
    }

    public function actionInit(){

        $data = array(
            'webService' => 'http://xckq.kasday.cn', 
            'startImg' => '', 
            'defaultImgUrl' => 'http://xckq.kasday.cn/upload/images/start_img.png', 
            'startImgUrl' => 'http://xckq.kasday.cn/upload/images/start_img.png', 
            'androidMustUpdate' => 0, 
            'androidUpdateUrl' => 'http://xckq.kasday.cn/download/schoolbus_versioncode2.apk', 
            'versionCode' => '2', 
            'language' => array(
                'system_welcome' => CONFIG('language_system_welcome'), 
                'system_online' => CONFIG('language_system_online'), 
                'system_mode_goto_school' => CONFIG('language_system_mode_goto_school'), 
                'system_mode_leave_school' => CONFIG('language_system_mode_leave_school'), 
                'student_get_up' => CONFIG('language_student_get_up'), 
                'student_get_off' => CONFIG('language_student_get_off'), 
                'station_not_match' => CONFIG('language_station_not_match'), 
                'station_arrive' => CONFIG('language_station_arrive'), 
                'station_leave' => CONFIG('language_station_leave'), 
                'station_next' => CONFIG('language_station_next'), 
            )
        );
        $this->success('initData',$data);
    }

    public function actionDeviceLogin(){

        $rules = [
            'deviceSn' => ['notBlank'], 
            'password' => ['notBlank'], 
        ];
        $data = $this->validateInput($rules);
        
        try {
            $data = DeviceModel::getInstance()->deviceLogin($data['deviceSn'],$data['password']);
            $this->success('登录成功',$data);
        }
        catch (SException $e) {
            $this->error($e->getMessage());
        }

    }


}
