<?php
namespace console\jobs;


use Yii;
use yii\queue\Job;
use common\models\User;
use common\models\Product;
use common\models\UserPayment;
use common\models\UserOrder;
use common\models\UserPaymentModel;

class EmailJob extends BaseJob implements Job {

    public function execute($queue)
    {
       // TODO: Implement execute() method.
       switch ($this->type){
           case 'welcome':
           case 'donationNotice':
           case 'paymentConfirm':
           case 'paymentConfirmed':
           case 'resetPassword':
           case 'orderFinished':
           case 'donationExprie':
               $method = $this->type;
               return $this->$method($this->relativeId);
               break;
           default:
               return false;
       }
    }

    public function welcome($userId){

        $user = User::getInstance($userId);

        $subject = 'Welcome To Crowdfunding Team';
        $content = "<p>Hello ".$user -> getName().",</p>";
        $content .= "<p>We are so glad to witness your partake and welcome to our big family of Crowndfunding.<br>";
        $content .= "Now you can start your donation.If you have any questions you can contact us with this E-mail.</p><br>";
        $content .= "<p>Thank you, your Crowdfunding Team!</p>";
        $this->_send($subject,$content,$user->getEmail());
    }

    public function donationNotice($orderId){


        $userPaymentList = UserPaymentModel::getInstance()->getOrderPaymentList($orderId);   
        $userOrder = UserOrder::getInstance($orderId);    

        $paymentContent  = "";
        foreach ($userPaymentList as $key => $userPayment) {
          $receiveUser = User::getInstance($userPayment->getReceiveUserId());
          $paymentContent .= "<p>You have cycled/upgraded and must send a Donation in the amount of <b>$".$userPayment->getAmount()."</b> to ".$receiveUser->getName().".<br>";
          $paymentContent .= "Login to your site and get ".$receiveUser->getName()."'s contact info from “My Money” and give them a call or send them an email to get instructions on how to send your Donation(s).</p><br>";
        }

        $sendUser = User::getInstance($userOrder->getUserId());

        $subject = 'Donation Notice';
        $content = "<p>Hello ".$sendUser -> getName().",</p>";
        $content .= $paymentContent;
        $content .= "<p>Thank you, your Crowdfunding Team!</p>";

        $this->_send($subject,$content,$sendUser->getEmail());
    }

    public function paymentConfirm($paymentId){

        $userPayment = UserPayment::getInstance($paymentId);

        $sendUser = User::getInstance($userPayment->getSendUserId());
        $receiveUser = User::getInstance($userPayment->getreceiveUserId());

        $subject = 'Payment Confirm';
        $content = "<p>Hello ".$receiveUser -> getName().",</p>";
        $content .= "<p>Please confirm whether ".$sendUser -> getName()." has transfer to you for the donation whitch payment money is $".$userPayment->getAmount()." as soon as possible.<br>";
        $content .= "If you has not received the money,please contact to ".$sendUser -> getName()." ".$sendUser -> getMobile()."</p><br>";
        $content .= "<p>Thank you, your Crowdfunding Team!</p>";

        $this->_send($subject,$content,$receiveUser->getEmail());
    }

    public function paymentConfirmed($paymentId){

        $userPayment = UserPayment::getInstance($paymentId);

        $sendUser = User::getInstance($userPayment->getSendUserId());
        $receiveUser = User::getInstance($userPayment->getreceiveUserId());

        $subject = 'Payment Confirmed';
        $content = "<p>Hello ".$sendUser -> getName().",</p>";
        $content .= "<p>Your payment of the donation whitch donation order money is $".$userPayment->getAmount()." has been confirmed. Please weiXin your donation status.<br>";
        $content .= "Have a good day!</p><br>";
        $content .= "<p>Thank you, your Crowdfunding Team!</p>";

        $this->_send($subject,$content,$sendUser->getEmail());

    }

    public function orderFinished($orderId){

        $userOrder = UserOrder::getInstance($orderId); 

        $user = User::getInstance($userOrder->getUserId());
        $product = Product::getInstance($userOrder->getProductId());

        $subject = 'Order Finished';
        $content = "<p>Hello ".$user -> getName().",</p>";
        $content .= "<p>Congratulations!</p>";
        $content .= "<p>You have completed your donation whitch donation order money is ".$product->getProductName()." in ".date('Y-m-d H:i:s', $userOrder->getEndTime()).". Now, you could have your new donation.<br>";
        $content .= "Have a good day!</p><br>";
        $content .= "<p>Thank you, your Crowdfunding Team!</p>";

        $this->_send($subject,$content,$user->getEmail());

    }

    public function resetPassword($userId){

        $user = User::getInstance($userId);

        $subject = 'Reset Password';
        $content = "<p>Hello ".$user -> getName().",</p>";
        $url = "http://www.5050ccf.com/index/resetPassword?key=".$user->getPasswordKey();
        $content .= "<p>Modify the password link <a href=".$url.">".$url."</a>, please click the link to change your password.</p>";
        $content .= "<p>Links are valid for two hours.</p>";

        $content .= "<p>Thank you, your Crowdfunding Team!</p>";
        

        $this->_send($subject,$content,$user->getEmail());
    }

    private function _send($subject,$content,$to='',$from='service@5050ccf.com'){
      // var_dump($subject,$content,$to);exit;
        Yii::$app->mailer->compose()
            ->setFrom($from)
            ->setTo($to)
            ->setSubject($subject)
            ->setHtmlBody($content)
            ->send();
    }

}