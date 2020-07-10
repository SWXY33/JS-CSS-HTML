<?php

namespace common\components;

define("AOP_SDK_WORK_DIR", dirname(__FILE__)."/../../frontend/runtime/");
require_once  dirname(__FILE__).'/alipay/AopSdk.php';

use common\models\Payment;
class AlipayPlus {
    public function checkPayment($payment) {
        $aop = new \AopClient();
        $aop->gatewayUrl = "https://openapi.alipay.com/gateway.do";
        $aop->appId = "2019052665368398";
        $aop->rsaPrivateKey = 'MIIEowIBAAKCAQEAn651f4T7FdAzrSudUnhCpM1EExKwalmmDmElpYvPR+NpHvYMJn0FOho497p8K/f/LXmaub/xb3oFkStp/578Jcnq32Wk7F5YO9O3R8H1yEuamjaEQEdc5WI6/iEKnX7DvYTTzrkHNF9tUDEx5dmjo6qfiAuzjyZuRhLzaGvOAN6lVpQn8QiGm//MrCJJiAJ06IPxLvb8r++4a7wvAcJwdpiz77WXAlzGcIYlCOmGW66AlkFaGTa/dYifRViEQYw+rYa27+qlOjpOxNL9bIoZCiiKaxuFNBMOanHgOALA3hBR3J2k0MVYLlYvnhd4rwY3VIJ1vBTtgely0qtInxFdawIDAQABAoIBAAYh+CdGnzIORf3PoAIr1jtoGsY0wIvFF6iTuJNsFDDpnf7vajYMNSgvG6MACYbSxn0jn3qk0Yv7fr09kpubqol1AM1FpRji4rahgfeCjoL7zFtB3sBtPTceF6/s6vBzjub3c/8LgihTxen/ibAPNMazZd8eu+2yhyev0KNhCI9l7iG7RC3K7EflgYtbWL3IIJ98wBDsAtTC7gQKHsFuzK3gGSeuEbO+O06qQuhd9Cgh92suiTYkHj6Qgoe+skNWyh7eIYCXyE25//8bt2NogkjvpMWJeoGoQyneM57zym5TaVw/mYsx3z9I1o5+hxge2W0+ZjdnUsqUeHh8ee3GINkCgYEAzCWJ1SEnJas+Xq8FVFEKBIh8o8/e28GRbTq++Xg04CAg1FtT9OuHRjsmXUjtO950IRNoAp6ipZeQIx7nApCn/LHA+1sXqyn3RqGxipSQoLmcWJ6UOSGbCaVse/q1kPwJp1CEhazEjyTuAV+u5ijPoXeHPmzTrV3uEL7NsDk8kI8CgYEAyD2cltlUMzCmbpzod2NuLRVWK/FX0r2SmDAPVYTrbeRFumB8wBy9ZAu3syQUpdCDwB53qWMM5DKD6uJ6qNhZYQoWc5mTUWEW0RobmckIp95wJxnnNCgn/gspptfBMoP2OKsfjOel0CPxtN8za7UbRZsXi79iYz1h5meTtnpe22UCgYBW7gkyU2q7FJ97bCXl0Jhmc8Q3cTXh+Bw4GhLmYjSJ18SDCNzIZ170Hg3pHTvACasDxqK8stZpkw+SlP8jzXtrFDosDo8WmMkuL35Nl5O6jS8xYV2WsmO1iNaYOJsGQPzPXW8BCR+uILikpxzv7yLzC9XwVCETKvNL+CPYTZcnqwKBgBlFZVDIZs77EdYd6Vy/6LS536E2GT5YfHrGffjuCIRa7c3ixXu9ZM2OiQWLxStUEHybm8B95q+aDHoFUTOj8kvD6Sd3t1bq6OVE5TzYWUZOVVsp8rrrYni2UfBjhFdqvhVSy22OAqgtESEhliy+s41qUGNrqPAbXBKm+cZq1TPdAoGBALtTWghhhGeDyKNtRi7MiEp+6G+tUmxK4hOSA/LTx75l+SAChMChvX7S+I+zFtCInPJFcb/ifAm2fnr/27Z1CYnkOd0dQGbcSx9hrLCjNkNMgjlu4CL2IBMvnLNvf3xkzLr4wEETkG7+0juuZLTcItE7C/hYP7MTRH2zqhRZtV+x';
        $aop->format = "json";
        $aop->charset = "UTF-8";
        $aop->signType = "RSA2";
        $aop->alipayrsaPublicKey = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAucQBEdhepejb8aMZAHRY68rX9PnJ+LFmYgCcTnGRB35wnRujCUTbeciBjMoR9P8UuWdsqbT50z12D3j1jdB+n/YlhoI+KJutY0M7iIM5zjb+o0riuB3z4bHGswoFWyF6mAUaQB0ow7jA7VG7J60/1FDSwAb3Kyqg74EBEnWEslbjh12bVJeS8hW2g68dNLHc6mL7tve+B2jJVLp2hqsKwmTGW9HDmnxXcAJwG/Mv9oreQXatq6V7bSqaxAoaixoq8LHp14hRrp7eTi7o0662wyw1frLwxrhz+2SZz3LO9cmhXqaLzdQ3onpmk21Jfehj9jNp9F3TMMTLaXKNmEhkMwIDAQAB';
        //实例化具体API对应的request类,类名称和接口名称对应,当前调用接口名称：alipay.trade.app.pay
        $request = new \AlipayTradeAppPayRequest();
        //SDK已经封装掉了公共参数，这里只需要传入业务参数
        $bizcontent = json_encode(array(
            'body'=>$payment->getContent(),
            'subject'=>$payment->getContent(),
            'out_trade_no'=>$payment->getPaymentId(),
            'timeout_express'=>'30m',
            'total_amount'=> $payment->getMoney(),
            'product_code'=>'QUICK_MSECURITY_PAY',
        ));
        $request->setNotifyUrl("https://app.zhongchuangjin.com/pay/alipayNotice");
        $request->setBizContent($bizcontent);
        //这里和普通的接口调用不同，使用的是sdkExecute
        $response = $aop->sdkExecute($request);
        return $response; //就是orderString 可以直接给客户端请求，无需再做处理。
    }

    public function checkResponse() {
        $aop = new \AopClient;
        $aop->alipayrsaPublicKey = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAucQBEdhepejb8aMZAHRY68rX9PnJ+LFmYgCcTnGRB35wnRujCUTbeciBjMoR9P8UuWdsqbT50z12D3j1jdB+n/YlhoI+KJutY0M7iIM5zjb+o0riuB3z4bHGswoFWyF6mAUaQB0ow7jA7VG7J60/1FDSwAb3Kyqg74EBEnWEslbjh12bVJeS8hW2g68dNLHc6mL7tve+B2jJVLp2hqsKwmTGW9HDmnxXcAJwG/Mv9oreQXatq6V7bSqaxAoaixoq8LHp14hRrp7eTi7o0662wyw1frLwxrhz+2SZz3LO9cmhXqaLzdQ3onpmk21Jfehj9jNp9F3TMMTLaXKNmEhkMwIDAQAB';
        $this->log(json_encode($_POST));
        $flag = $aop->rsaCheckV1($_POST, NULL, "RSA2");
        if( $flag ) {
            $result = $_POST;
            $paymentId = intval($result["out_trade_no"]);
            $payment = Payment::getInstance($paymentId);
            if( $payment->getPayState()==1 ){
                $this->log("set payment ignore :" .$paymentId);
                echo 'success';
            }
            elseif( $payment->setPay(PAYMENT_PAY_TYPE_ALIPAY_APP,$result['trade_no'],$result)){
                $this->log("set payment success :" . $paymentId);
                echo 'success';
            }
            else {
                $this->log("set payment failed :" . $paymentId);
                echo 'faild';
            }
        } else {
            $this->log('weiXin fail:'.json_encode($flag));
        }
    }

    protected function log($message){
        $message = date('Y-m-d H:i:s ').$message."\r\n";
        $logfile = SYSTEM_ROOT.'/frontend/runtime/alipay'.date('Ymd').'.log';
        error_log($message,3,$logfile);
    }

}
