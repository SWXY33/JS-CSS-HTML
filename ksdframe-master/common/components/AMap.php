<?php
namespace common\components;

class AMap {
    private $_key ;
    public function __construct($key)
    {
        $this->_key = $key;
    }

    public function getCodeGeo($address){
        $url = "https://restapi.amap.com/v3/geocode/geo?address={$address}&key={$this->_key}";
        $result = $this->getResult($url);
        return is_array($result['geocodes'])?current($result['geocodes']):array();
    }

    public function getGeo($location){
        $url = "https://restapi.amap.com/v3/geocode/regeo?location={$location}&key={$this->_key}";
        $result = $this->getResult($url);
        //var_dump($result['regeocode']); exit;
        return isset($result['regeocode'])?$result['regeocode']:array();

    }

    public function getResult($url,$paramString=false,$isPost=0){
        $response = $this->getResponse($url,$paramString,$isPost);
        $result = json_decode($response,true);
        if($result){
            if($result['status']=='1'&&$result['info']=='OK'){
                return $result;
            }else{
                throw new CException('接口错误['.$result['infocode'].']:'.$result['info']);
            }
        } else {
            throw new CException('接口请求错误:'.$response);
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
}