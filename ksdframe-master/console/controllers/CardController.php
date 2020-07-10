<?php
namespace console\controllers;

use common\models\Card;
use common\models\CardModel;
use Yii;

class CardController extends BaseController {


    public function actionSearch($key){
        $cardList = [];
        $cardList[] = Card::getInstance($key);
        $cardList[] = CardModel::getInstance()->getCardByNumber($key);
        $cardList =  array_merge($cardList,Card::multiLoad("cardNumber like '%$key'"));
        $data = [['ID','卡号','姓名','可用分钟数','余额','父母手机号','学校']];
        foreach ($cardList as $card){
            if(!empty($card)&&$card->isExists()){
                $data[] = $card->getDataArray(['cardId','cardNumber','studentName','leftMins','money','parentMobile','schoolName']);
            }
        }
        $this->_show_data($data,12);
    }

    /**
     * 卡充值（时长、分钟）
     * @param $cardId 卡ID
     * @param $content 充值备注
     * @param int $leftMins 可用时长（分钟）
     * @param int $money 充值金额（元）
     * @throws \common\components\CException
     */
    public function actionCharge($cardId,$content,$leftMins=0,$money=0){
        $card = $this->_check_card($cardId);
        if( $card->cardCharge($leftMins,$money,$content) ){
            $this->message('Card ['.$card->getCardSn().'] charge [leftMins:'.$leftMins.'] [money:'.$money.'] success.');
        }
        else {
            $this->message('Card ['.$card->getCardSn().'] charge failed.');
        }
    }

    /**
     * 扣除卡的分钟数、余额
     * @param $cardId 卡ID
     * @param $content 扣除备注
     * @param int $leftMins 扣除分钟数
     * @param int $money 扣除金额
     * @throws \common\components\CException
     */
    public function actionReduce($cardId,$content,$leftMins=0,$money=0){
        $card = $this->_check_card($cardId);
        if( $card->cardReduce($leftMins,$money,$content) ){
            $this->message('Card ['.$card->getCardSn().'] reduce [leftMins:'.$leftMins.'] [money:'.$money.'] success.');
        }
        else {
            $this->message('Card ['.$card->getCardSn().'] reduce failed.');
        }
    }

    /**
     * 批量/单独添加卡
     * @param $cardNumberStart 卡号（批量为开始卡号）
     * @param int $cardNumberEnd （批量结束卡号）
     * @param int $state （是否激活0/1）
     */
    public function actionAdd($cardNumberStart,$cardNumberEnd=0,$state=1){
        if( empty($cardNumberEnd) ) $cardNumberEnd = $cardNumberStart;
        $result = CardModel::getInstance()->batchAddCard($cardNumberStart,$cardNumberEnd,$state);
        $this->message('add card success:'.$result['success'].';failed:'.$result['failed']);
    }

    /**
     * 批量充值（分钟数、余额）
     * @param $cardNumberStart 开始卡号
     * @param $cardNumberEnd 结束卡号
     * @param $content 充值备注
     * @param $leftMins 充值分钟数
     * @param $money 充值金额
     */
    public function actionBatchCharge($cardNumberStart,$cardNumberEnd,$content,$leftMins,$money){
        $result = CardModel::getInstance()->batchCharge($cardNumberStart,$cardNumberEnd,$leftMins,$money,$content);
        $this->message('add card success:'.$result['success'].';failed:'.$result['failed']);
    }

    /**
     * 校验IC卡是否存在
     * @param $cardId
     * @return array|mixed
     * @throws \common\components\CException
     */
    public function _check_card($cardId)
    {
        if (empty($cardId) || !($card = Card::getInstance($cardId)) || !($card->isExists())) {
            $this->message('card not found!');exit;
        }
        elseif ($card->getState()<=0) {
            $this->message('card state error.');exit;
        }
        else {
            return $card;
        }
    }

}

