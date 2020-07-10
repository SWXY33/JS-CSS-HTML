<?php
/**
 * 
 * User: PHPStorm
 * Date: 2017/12/2
 */

namespace common\models;


use common\components\CException;
use common\components\Model;

class JuheModel extends Model {

    const IP_KEY = 'f0b8221ef51187cbf10f10cdd5520819';
    const VIN_KEY = '';
    const OIL_PRICE_KEY = 'fdf498a2245f9d531f663b10fc76ef33';
    const GEO_KEY = '64eaa3cd8634d0b568c4c89070c9d29d';

    private static $smsKeys = array(
        JUHE_SMS_TEMPLATE_AUTHCODE => 'c907a174f26a9ae3f19c74392014b643',
    );

    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }
    // 以下为油卡通聚合信息
     // private static $openId = 'JH9039244b97eb0bd792d9ec0f7930edfb';
     // private static $appKey = '046b11d7ea38c5185169c6c87edccbe4';

    private static $productList = array(
        '50' => '10000',
        '100'   => '10001',
        '200'   => '10002',
        '500'   => '10003',
        '1000'   => '10004',
    );

    public function oilCharge($orderId,$money,$cardType,$cardNo,$cardName,$cardTel){
        $url = 'http://op.juhe.cn/ofpay/sinopec/onlineorder';
        if( empty(self::$productList[$money]) ) {
            throw new CException('错误的油卡金额');
        }
        if( $cardType==2 ){
            $proid = '10008';
        }
        else {
            $proid = self::$productList[$money];
            $money = 1;
        }

        $params = array(
            'proid' => $proid,
            'cardnum' => $money,//充值数量 任意充 （整数（元）），其余面值固定值为1
            'orderid' => $orderId,//商家订单号，8-32位字母数字组合
            'game_userid' => $cardNo,//加油卡卡号，中石化：以100011开头的卡号、中石油：以9开头的卡号
            'gasCardTel'  => $cardTel,//持卡人手机号码
            'gasCardName' => $cardName,//持卡人姓名
            'chargeType' => $cardType,//加油卡类型 （1:中石化、2:中石油；默认为1)
            'key' => self::$appKey,//应用APPKEY(应用详细页查询)
        );
        $params['sign'] = md5(self::$openId.self::$appKey.$params['proid'].$params['cardnum'].$params['game_userid'].$params['orderid']);//校验值，md5(OpenID+key+proid+cardnum+game_userid+orderid)
        $paramString = http_build_query($params);
        try {
            return $this->getResult($url,$paramString);
        }
        catch(CException $e) {
            throw $e;
        }
    }

    public function getOrderInfo($orderId){
        $url = 'http://op.juhe.cn/ofpay/sinopec/ordersta';
        $params = array(
            'orderid' => $orderId,//商家订单号，8-32位字母数字组合
            'key' => self::$appKey,//应用APPKEY(应用详细页查询)
        );
        $paramString = http_build_query($params);
        try {
            return $this->getResult($url,$paramString);
        }
        catch(CException $e) {
            throw $e;
        }
    }


    public function sendAuthCodeSms($mobile,$data){
        $url = 'http://v.juhe.cn/sms/send'; //短信接口的URL
        $paramString = http_build_query(array(
            'key'   => CONFIG('juhe_sms_key'), //您申请的APPKEY
            'mobile'    => $mobile, //接受短信的用户手机号码
            'tpl_id'    => CONFIG('juhe_sms_template_id'), //您申请的短信模板ID，根据实际情况修改
            'tpl_value' =>'#app#='.$data['app'].'&#code#='.$data['code'] //您设置的模板变量，根据实际情况修改
        ));
        return $this->getResult($url,$paramString,1);
    }


    public function idCardCheck($realName,$idCard){
        $url = 'http://op.juhe.cn/idcard/query';
        $params = array(
            'idcard' => $idCard,//身份证号码
            'realname' => $realName,//真实姓名
            'key' => CONFIG('juhe_idcard_key'),//应用APPKEY(应用详细页查询)
        );
        $paramString = http_build_query($params);
        //var_dump($paramString);exit;
        try {
            $result = $this->getResult($url,$paramString);
            if( $result['res'] == 1 ){
                return array('state'=>1,'message'=>'验证成功');
            }
            else {
                return array('state'=>0,'message'=>'姓名与身份证不匹配');
            }
        }
        catch (CException $e) {
            return array(
                'state' => 0,
                'message' => $e->getMessage()
            );
        }
    }


    public function getVinData($vin) {
        $url = 'http://v.juhe.cn/vinParse/query.php?vin='.$vin.'&key='.self::VIN_KEY;
        return $this->getResult($url);
    }

    public function getIpAreaTaobao($ip){
        $url = "http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip=$ip";
        $response = $this->getResponse($url);
        $result = json_decode($response,true);
        //var_dump($result); exit;
        return !empty($result['ret'])?($result['province'].$result['city']):'';
    }

    public function getIpArea($ip){
        $url = "http://apis.juhe.cn/ip/ip2addr";
        $params = array(
            "ip" => $ip,//需要查询的IP地址或域名
            "key" => self::IP_KEY,//应用APPKEY(应用详细页查询)
        );
        $paramString = http_build_query($params);
        $response = $this->getResponse($url,$paramString,1);
        $result = json_decode($response,true);
        if( $result['resultcode']=='200' ){
            return $result['result']['area'];
        }
        else {
            return '';
        }
    }

    public function getGeoData($lng,$lat,$type=3) {
        $cacheKey = $lng.'|'.$lat.'|'.$type;
        $result=$this->cache($cacheKey);
        if( empty($result) ){
            $url = 'http://apis.juhe.cn/geo/'; //接口的URL
            $paramString = http_build_query(array(
                'lng' => $lng,//经度 (如：119.9772857)
                'lat' => $lat,//纬度 (如：27.327578)
                'key' => self::GEO_KEY,//申请的APPKEY
                'type' => $type,//传递的坐标类型,1:GPS 2:百度经纬度 3：谷歌经纬度
                'dtype' => 'json',//返回数据格式：json或xml,默认json
            ));
            $result = $this->getResult($url,$paramString,1);
            $this->cache($cacheKey,$result,3600);
        }
        return $result;
    }


    public function getOilPrice(){
        $url = 'http://apis.juhe.cn/cnoil/oil_city?key='.self::OIL_PRICE_KEY;
        return $this->getResult($url);
    }


    public function getResult($url,$paramString=false,$ispost=0){
        $response = $this->getResponse($url,$paramString,$ispost);
        $result = json_decode($response,true);
        if($result){
            if($result['error_code']=='0'){
                return $result['result'];
            }else{
                throw new CException('接口错误['.$result['error_code'].']:'.$result['reason']);
            }
        } else {
            throw new CException('接口请求错误:'.json_encode($result));
        }
    }


    /**
     * 请求接口返回内容
     * @param string $url [请求的URL地址]
     * @param string $paramString [请求的参数]
     * @param int $isPost 是否采用POST形式
     * @return string
     * @throws CException 错误的异常
     */
    public function getResponse($url,$paramString='',$isPost=0){
        $httpInfo = array();
        $ch = curl_init();

        curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
        curl_setopt( $ch, CURLOPT_USERAGENT , 'JuheData' );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 60 );
        curl_setopt( $ch, CURLOPT_TIMEOUT , 60);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        if( $isPost )
        {
            curl_setopt( $ch , CURLOPT_POST , true );
            curl_setopt( $ch , CURLOPT_POSTFIELDS , $paramString );
            curl_setopt( $ch , CURLOPT_URL , $url );
        }
        else
        {
            if($paramString){
                curl_setopt( $ch , CURLOPT_URL , $url.'?'.$paramString );
            }else{
                curl_setopt( $ch , CURLOPT_URL , $url);
            }
        }
        $response = curl_exec( $ch );
        if ($response === FALSE) {
            throw new CException('cURL Error: ' . curl_error($ch));
        }
        $httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
        $httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
        curl_close( $ch );
        //var_dump($response,$httpCode,$httpInfo);
        return $response;
    }

    public function bankCardCheck($bankCard){
        $url = 'http://apis.juhe.cn/bankcardcore/query?bankcard='.$bankCard.'&key='.CONFIG('juhe_bankcard_key');
        $result = $this->getResult($url);
        if( !empty($result['bankname']) ){
           return $result;
        }else{
            return false;
        }
    }


}