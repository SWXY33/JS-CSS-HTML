<?php
/**
 * WxAppNotice.php create by PHPStorm
 * project:xiaocao2018
 * Time: 2018/7/12
 */
namespace common\components;

require_once  dirname(__FILE__).'/wxpay/WxPay.Config.php';
require_once  dirname(__FILE__).'/wxpay/lib/WxPay.Api.php';
require_once dirname(__FILE__).'/wxpay/lib/WxPay.Notify.php';

use common\models\Payment;

class WxAppNotice extends \WxPayNotify {

    public function Queryorder($transaction_id)
    {
        $input = new \WxPayOrderQuery();
        $input->SetTransaction_id($transaction_id);

        $config = new \WxPayConfig();
        $result = \WxPayApi::orderQuery($config, $input);
        $this->log("query:" . json_encode($result));
        if(array_key_exists("return_code", $result)
            && array_key_exists("result_code", $result)
            && $result["return_code"] == "SUCCESS"
            && $result["result_code"] == "SUCCESS")
        {
            $payment = Payment::getInstance($result["out_trade_no"]);
            if( $payment->getPayState()==1 ){
                $this->log("set payment ignore :" . $result["out_trade_no"]);
                return true;
            }
            elseif( $payment->setPay(PAYMENT_PAY_TYPE_WECHAT_PLAT,$result['transaction_id'],$result)){
                $this->log("set payment success :" . $result["out_trade_no"]);
                return true;
            }
            else {
                $this->log("set payment failed :" . $result["out_trade_no"]);
                return false;
            }
        }
        return false;
    }


    //重写回调处理函数
    /**
     * @param WxPayNotifyResults $data 回调解释出的参数
     * @param WxPayConfigInterface $config
     * @param string $msg 如果回调处理失败，可以将错误信息输出到该方法
     * @return true回调出来完成不需要继续回调，false回调处理未完成需要继续回调
     */
    public function NotifyProcess($objData, $config, &$msg)
    {
        $data = $objData->GetValues();
        //TODO 1、进行参数校验
        if(!array_key_exists("return_code", $data) 
            ||(array_key_exists("return_code", $data) && $data['return_code'] != "SUCCESS")) {
            //TODO失败,不是支付成功的通知
            //如果有需要可以做失败时候的一些清理处理，并且做一些监控
            $msg = "异常异常";
            return false;
        }
        if(!array_key_exists("transaction_id", $data)){
            $msg = "输入参数不正确";
            return false;
        }

        //TODO 2、进行签名验证
        try {
            $checkResult = $objData->CheckSign($config);
            if($checkResult == false){
                //签名错误
                $this->log("签名错误...");
                return false;
            }
        } catch(Exception $e) {
            $this->log(json_encode($e));
        }

        //TODO 3、处理业务逻辑
        $this->log("call back:" . json_encode($data));
        $notfiyOutput = array();
        
        
        //查询订单，判断订单真实性
        if(!$this->Queryorder($data["transaction_id"])){
            $msg = "订单查询失败";
            return false;
        }
        return true;
    }


    public function checkResponse() {
        $config = new \WxPayConfig();
        $this->Handle($config, false);
    }

    protected function log($message){
        $message = date('Y-m-d H:i:s ').$message."\r\n";
        $logfile = SYSTEM_ROOT.'/frontend/runtime/wxpay'.date('Ymd').'.log';
        error_log($message,3,$logfile);
    }

}
