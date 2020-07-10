<?php

namespace common\components;

require_once  dirname(__FILE__).'/wxpay/lib/WxPay.Api.php';
require_once  dirname(__FILE__).'/wxpay/WxPay.Config.php';

class WxAppPay  {
    public function checkPayment($payment) {
        $input = new \WxPayUnifiedOrder();
        $input->SetBody($payment->getContent());
        $input->SetAttach($payment->getContent());
        $input->SetOut_trade_no($payment->getPaymentId());
        $input->SetTotal_fee($payment->getMoney()*100);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetTrade_type("APP");
        $config = new \WxPayConfig();
        $order = \WxPayApi::unifiedOrder($config, $input);

        if( $order['return_code']=='FAIL' ){
            throw new SException($order['return_msg']);
        }
        else {
            return $this->getAppParameters($order);
        }
    }
 
    private function getAppParameters($UnifiedOrderResult)
    {    //判断是否统一下单返回了prepay_id
        if(!array_key_exists("appid", $UnifiedOrderResult)
        || !array_key_exists("prepay_id", $UnifiedOrderResult)
        || $UnifiedOrderResult['prepay_id'] == "")
        {
            throw new \WxPayException("参数错误");
        }

        $dataObj = new ApiData();
        $config = new \WxPayConfig();
        $dataArray = array(
            'appid' => $config->GetAppId(),
            'partnerid' => $config->GetMerchantId(),
            'prepayid' => $UnifiedOrderResult['prepay_id'],
            'package' => 'Sign=WXPay',
            'noncestr' => \WxPayApi::getNonceStr(),
            'timestamp' => time(),
        );
        foreach( $dataArray as $key=>$value ) {
            $dataObj->setData($key,$value);
        }
        //$dataObj->SetSign($config);
        $dataObj->SetData('sign',$dataObj->MakeSign($config,false));
        $data = $dataObj->GetValues();
        //return $data;
        //{"appid":"wx4e1ba1da22091f9a","noncestr":"ny5f0ehqh5lqaoquoixvv9t18tq0e87f","package":"Sign=WXPay","partnerid":"1537207381","prepayid":"wx3122185866149944fda9205c8205816900","sign_type":"MD5","timestamp":1559312338,"sign":"25E60848AE397973240373288336966B"}
        return array(
            'apiKey' =>$data['appid'],
            'orderId' => $data['prepayid'],
            'mchId' => $data['partnerid'],
            'nonceStr' => $data['noncestr'],
            'timeStamp' => $data['timestamp'],
            'package' => $data['package'],
            'sign' => $data['sign']
         );
    }
}

class ApiData extends \WxPayDataBase {
    public function setData($key,$value) {
         $this->values[$key]=$value;
    }
}


