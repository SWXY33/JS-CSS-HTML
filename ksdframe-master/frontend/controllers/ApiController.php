<?php

namespace frontend\controllers;

use common\components\SException;
use common\components\Util;
use common\models\CardModel;
use common\models\DeviceModel;
use common\models\FeeLog;
use common\models\SchoolModel;
use common\models\UserModel;
use Yii;

class ApiController extends BaseController
{

    public function init(){
        parent::init();
        $whileIpList = explode(',',CONFIG('api_iplist_white'));
        $realIp = Util::getRealIp();
        if($realIp!='127.0.0.1'&&!in_array($realIp,$whileIpList)){
            exit('Access Denied!');
        }
    }

    public function actionIndex(){
        exit('Access Denied!');

    }

    public function actionFee(){
        $data = urldecode($this->request->post('cdr'));
        if( empty($data) ) $this->error('empty data');
        $obj = json_decode($data,true);
        if( !empty($_GET['uuid'])&&!empty($obj) ){
            $filename = $_GET['uuid'].'.json';
            $this->_save_json($data,$filename);
        }
        $result = array();
        if(!empty($obj['variables']['direction']) && $obj['variables']['direction'] == 'outbound' && !empty($obj['callflow'][0])){
            $callflow=$obj['callflow'][0];
            //话机账号
            $result['deviceId'] = $callflow['caller_profile']['username'];
            //主叫学生卡账号
            $result['cardNumber'] =$callflow['caller_profile']['caller_id_number'];

            //被叫家长手机号
            $result['phone']=substr($callflow['caller_profile']['destination_number'],4);
            $result['feeNo']=$obj['variables']['originating_leg_uuid'];
            //通话开始时间
            $result['beginTime']=$obj['variables']['start_epoch'];
            $result['endTime']=$obj['variables']['end_epoch'];
            //通话时长
            $result['talkTime']=$obj['variables']['billsec'];
            $feeLog = FeeLog::add($result['cardNumber'],$result['phone'],$result['beginTime'],$result['endTime'],$result['talkTime'],$result['deviceId'],$result['feeNo']);
            //直接执行扣费逻辑，后期可使用队列
            $feeLog->doReduceFee();

            $this->displayData(['feeId'=>$feeLog->getFeeLogId()]);
        }
        else {
            $this->error('empty decode data');
        }
    }


    public function actionWechat($api="",$params=""){
        $api = intval($api);
        $params = json_decode($params,true);
        if(empty($params)) $this->error('参数错误',$api);
        $data = [];
        try {
            switch ($api) {
                case 1001://登录验证 {"uuid":"1212","phone":"15982189049","password":"111111"}
                    UserModel::getInstance()->doLogin($params['phone'],$params['password'],$params['uuid']);
                    break;
                case 1002://注册接口 {"phone":"18030578633","password":"111111","uuid":''1212"}
                    UserModel::getInstance()->doRegister($params['phone'],$params['password'],$params['uuid']);
                    break;
                case 1003://修改密码 {"phone":"18030578633","oldPassword":"111111","password":"111111","uuid":''1212"}
                    UserModel::getInstance()->changePassword($params['phone'],$params['oldPassword'],$params['password'],$params['uuid']);
                    break;
                case 1004://绑定卡号 {"cardnum":"053901487","name":"小明","grad":"1","class":"3","uuid":"07163030"}
                    $params['grad'] = empty($params['grad'])?'':$params['grad'];
                    $params['class'] = empty($params['class'])?'':$params['class'];
                    UserModel::getInstance()->doCardBind($params['cardnum'],$params['name'],$params['uuid'],$params['grad'],$params['class']);
                    break;
                case 1005://查询卡号 {"phone":"15982189049","uuid":"1212"}
                    $data = UserModel::getInstance()->getCard($params['phone'],$params['uuid']);
                    break;
                case 1006://通话记录 {"cardnum":"053901487","uuid":"1212"}
                    $data = UserModel::getInstance()->getFeeLog($params['cardnum']);
                    break;
                case 1007://充值接口 {"cardnum":"053901487","fee":"10","orderid":"","uuid":"1212"}
                    UserModel::getInstance()->doCharge($params['cardnum'],$params['fee'],$params['orderid'],$params['uuid']);
                    break;
                case 1008://充值记录 {"cardnum":"053901487","uuid":"1212"}
                    $data = UserModel::getInstance()->getChargeLog($params['cardnum']);
                    break;
                case 1009://生成订单 {"uuid":"1212"}
                    $data = UserModel::getInstance()->addChargeOrder($params['uuid']);
                    break;
                case 1010://查询学校 {"county":"桓台","uuid":"1212"}
                    $data = UserModel::getInstance()->getCountySchoolList($params['county']);
                    break;
                case 1011://解除绑定 {"uuid":"1212","account":"053901487"}
                    UserModel::getInstance()->doCardUnbind($params['account'],$params['uuid']);
                    break;
                case 1012://查询余额 {"cardnum":"053901487","uuid":"07163030"}
                    $data = CardModel::getInstance()->getCardSurplus($params['cardnum']); //要返回金额及可用分钟数
                    break;
                case 1013://查询卡号的详细信息 {“account”:”卡号”}
                    $data = CardModel::getInstance()->getCardData($params['account']); 
                    break;
                case 1014://查询微信充值订单是否已存在 {“orderid”:”20200114182646163860”}
                    $state = UserModel::getInstance()->checkWxOrder($params['orderid']); 
                    if ($state) {
                        $this->result([],$api);
                    }else{
                        $this->error('',$api);
                    }
                    break;
                case 1015://通过微信用户openid查询用户绑定卡号的余额，剩余分钟数 {“uuid”:”微信ID”}
                    $data = UserModel::getInstance()->getCardAccount($params['uuid']); 
                    break;
                case 1016://通过openId检测用户是否注册
                    $info = UserModel::getInstance()->getUserByOpenId($params['uuid']);
                    if ($info) {
                         $this->result(['phone'=>$info->mobile],$api,'已注册');
                    }else{
                        $this->error('未注册',$api);
                    }
                    break;
                default:
                    $this->error('接口错误',$api);
            }
            $this->result($data,$api);
        }
        catch (SException $e){
            $this->error($e->getMessage(),$api);
        }
    }

    public function actionVos(){
        $api = intval($this->request->get('api'));
        switch ($api){
            case 101: //查询余额
                $cardNumber = $this->request->get('cardno');
                $card = CardModel::getInstance()->getCardByNumber($cardNumber);
                echo $card->getMoney(); exit;
                break;
            case 105: //查询话机路由前缀
                $deviceAccount = $this->request->get('sip_name');
                $device = DeviceModel::getInstance()->getDeviceByAccount($deviceAccount);
                echo $device->getLinePrefix(); exit;
                break;
            case 106: //查是否允许呼叫
                $cardNumber = $this->request->get('cardno');
                $phone = $this->request->get('phone');
                $card = CardModel::getInstance()->getCardByNumber($cardNumber);
                //0:允许呼叫 1:卡挂失 2:余额不足
                echo $card->checkTalkAccess($phone); exit;
                break;
            default:
                exit('ERROR');
        }
    }


    protected function error($message='系统错误',$data = array()){
        echo json_encode(['error'=>1,'api'=>$data,'message'=>$message]);exit;
    }

    protected function result($data,$api,$message='success'){
        echo json_encode(array_merge(['error'=>0,'api'=>$api,'message'=>$message],$data));exit;
    }

    protected function _save_json($data,$filename){
        $path = dirname(__FILE__).'/../runtime/apidata/'.date('Ymd');
        if( !is_dir($path) ) mkdir($path,0777,true);
        file_put_contents($path.'/'.$filename,$data);
    }

}
