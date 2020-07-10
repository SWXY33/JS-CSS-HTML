<?php

namespace common\models;
use common\components\CException;
use Yii;
use common\components\Model;
use common\models\weixinToken;

class WeiXinModel extends Model{

    public function createWxQrCode($url,$nameKey){
        $basePath = SYSTEM_ROOT.'/frontend/web/static/qrcode/';
        $fileName = $nameKey.'.png';
        $response = $this->getAppQrCode($url);
        return file_put_contents($basePath.$fileName, $response);
    }


    public function getAppQrCode($url){
        $token = $this->getToken();

        $body = array(
            'path' => $url,//'pages/reg/reg?phone='.$phone
            'width' => 430,
            'is_hyaline' => true,
        );

        $url='https://api.weixin.qq.com/wxa/getwxacode?access_token='.$token;

        $body = json_encode($body,true);
        return $this->getResponse($url,$body,1);
    }

    public function getToken(){
        $tokenState = $this->valid();
        if ($tokenState) {
            return weixinToken::getInstance(1)->getToken();
        } else {

            $url = 'https://api.weixin.qq.com/cgi-bin/token';
            $params = array(
                'grant_type' => 'client_credential',
                'secret' => CONFIG('app_secret'),
                'appid' => CONFIG('appid'),
            );

            $paramString = http_build_query($params);
            $response = $this->getResponse($url,$paramString,0);
            $data = json_decode($response,true);
            $token = $data['access_token'];
            

            weixinToken::getInstance(1)->updateToken($token);
            return $token;
            
        }

    }

    public function valid(){

        $getDate = weixinToken::getInstance(1)->getGetDate();
        //var_dump($getDate,strtotime($getDate),time() - strtotime($getDate));  exit;
        $state = time() - strtotime($getDate) < 3000 ? true : false;
        return $state;

    }

        /**
     * 请求接口返回内容
     * @params  string $url [请求的URL地址]
     * @params  string $paramString [请求的参数]
     * @params  int $isPost 是否采用POST形式
     * @return  string
     * @throws CException 错误的异常
     */
    public function getResponse($url,$paramString=false,$isPost=0){
        $httpInfo = array();
        $ch = curl_init();

        curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 60 );
        curl_setopt( $ch, CURLOPT_TIMEOUT , 60);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
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
        curl_close( $ch );
        //$httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
        //$httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
        //var_dump($response,$httpCode,$httpInfo);
        return $response;
    }

}