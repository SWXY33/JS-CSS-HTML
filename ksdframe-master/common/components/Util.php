<?php
/*
 * 通用系统函数
 *
 *
 *
 */
namespace common\components;


use common\components\chinese\Bihua;

class Util {

    /**
     * 从配置文件载入配置信息
     * @param $k
     * @param bool $cache
     * @param null $params
     * @return null
     */
    public static function loadConfig($k, $cache = true, $params = null) {
        static $cfg = array();
        if (!isset($cfg[$k]) || !$cache) {
            if ($params) {
                foreach ($params as $name => $value) {
                    $$name = $value;
                }
            }
            if (file_exists(dirname(__FILE__) . '/../config/data/' . $k . '.php')) {
                $cfg[$k] = require(dirname(__FILE__) . '/../config/data/' . $k . '.php');
            }
        }
        if (isset($cfg[$k])) {
            return $cfg[$k];
        } else {
            return null;
        }
    }

    public static function getFormulaResult($formula,$data) {
        extract($data);
        $code = '$result = ('.$formula.');';
        $res = eval($code);
        return $result;
    }

    /**
     * @param $timestamp
     * @return int
     */
    public static function getDayTime($timestamp) {
        return mktime(0, 0, 0, date("m", $timestamp), date("d", $timestamp), date("Y", $timestamp));
    }

    public static function getMonthTime($timestamp) {
        return mktime(0, 0, 0, date("m", $timestamp), 1, date("Y", $timestamp));
    }

    public static function getNextMonthTime(){
        return strtotime(date('Y-m-01 00:00:00',strtotime('next month')));
    }

    public static function getUpdateTimeStr($timestamp) {
        return date("Y-m-d H:i:s");
    }

    public static function makeToken($uid = '') {
        return base64_encode(md5(microtime() . rand(1, 100000) . TOKEN_SECRET_KEY));
    }

    public static function makeSign($uid = '', $token = '') {
        return base64_encode(md5($uid . $token));
    }

    /**
     * 允许的ip返回为true，不允许的ip返回为false
     */
    public static function checkIp() {
        $list = Util::loadconfig('ipCheckList');
        $realIp = Util::getRealIp();
        foreach ($list as $item) {
            if (preg_match($item, $realIp)) {
                return true;
            }
        }
        return false;
    }

    /**
     * 获取客户端的真实IP
     * @return string 真实IP地址
     */
    static function getRealIp() {
        if (getenv('HTTP_X_REAL_IP')) {
            $ip = getenv('HTTP_X_REAL_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $remote_addr = getenv("HTTP_X_FORWARDED_FOR");
            $tmp_ip = explode(",", $remote_addr);
            $ip = $tmp_ip[0];
        } elseif (getenv('HTTP_CLIENT_IP')) {
            $ip = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('REMOTE_ADDR')) {
            $ip = getenv('REMOTE_ADDR');
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        } else {
            $ip = "";
        }
        return $ip;
    }

    /**
     * 通过POST的方式请求远程数据
     * @param $url
     * @param $data
     * @return mixed
     */
    public static function postRequest($url,$data){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($ch,CURLOPT_COOKIEJAR,null);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        $content = curl_exec($ch);
        return $content;
    }

    /**
     * 获得一个随机字符串
     * @param int $length 长度
     * @param string $prefix 前缀
     * @return string
     */
    public static function getHashString($length=6,$prefix=''){
        return $prefix.substr( md5(microtime()),0,$length );
    }

    /**
     * 格式化如 a：1:b:2；c:3简化数据格式为数组
     * @param $string
     * @return array
     */
    public static function stringToArray($string) {
        $string = str_replace("；",";",$string);
        $string = str_replace("：",":",$string);
        $string = str_replace("，",",",$string);
        $string = str_replace(",",";",$string);
        $result = array();
        foreach( explode(";",$string) as $r ) {
            $r = trim($r);
            if( empty($r) ){
                continue;
            }
            $v = explode(":",$r);
            if( empty($v[1]) ){
                $result[] = $v[0];
            }
            else {
                $result[$v[0]] = $v[1];
            }
        }
        return $result;
    }

    /**
     * 将数据存储为简化数据字符串
     * @param $array
     * @return string
     */
    public static function arrayToString($array) {
        if( empty($array)||!is_array($array) ){
            return '';
        }
        $stringArray = array();
        foreach( $array as $k=>$v ){
            $stringArray[] = "{$k}:{$v}";
        }
        return implode(";",$stringArray);
    }

    public static function isMobile($mobile){
        return preg_match('/^1[3-8][0-9]{9}$/',$mobile);
    }

    public static function getHumanTime($time){
        $spaceTime = time()-$time;
        if( $spaceTime<60 ){
            return '1分钟内';
        }
        elseif ( $spaceTime<3600 ){
            return floor($spaceTime/60).'分钟前';
        }
        elseif ( $spaceTime<86400 ){
            return floor($spaceTime/3600).'小时'.floor($spaceTime%3600/60).'分前';
        }
        elseif( $spaceTime<86400*30 ) {
            return floor($spaceTime/86400).'天'.floor($spaceTime%86400/3600).'小时前';
        }
        elseif( $spaceTime<86400*300 ) {
            return date('m-d H:i',$time);
        }
        else {
            return date('Y-m-d',$time);
        }
    }


    /**
     * 校验车辆VIN编号是否有效
     * 使用vin的校验算法，直接计算出vin是否有效
     * @param string $sVin 车辆的VIN码
     * @return boolean true:校验通过 | false:校验失败
     */
    public static function checkVin($sVin){
        static $aCharMap = array(
            '0'=>0,'1'=>1,'2'=>2,'3'=>3,'4'=>4,'5'=>5,'6'=>6,'7'=>7,'8'=>8,'9'=>9,
            'A'=>1,'B'=>2,'C'=>3,'D'=>4,'E'=>5,'F'=>6,'G'=>7,'H'=>8,'J'=>1,'K'=>2,
            'L'=>3,'M'=>4,'N'=>5,'P'=>7,'R'=>9,'S'=>2,'T'=>3,'U'=>4,'V'=>5,'W'=>6,
            'X'=>7,'Y'=>8,'Z'=>9
        );
        static $aWeightMap = array(8,7,6,5,4,3,2,10,0,9,8,7,6,5,4,3,2);
        foreach (array_keys($aCharMap) as $sNode){//取出key
            $aCharKeys[] = strval($sNode);
        }
        $sVin = strtoupper($sVin); //强制输入大写
    
        if (strlen($sVin) !== 17){
            return false; //长度不对
        }elseif (!in_array($sVin{8}, array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'X')) ) {
            return false; //校验位的值不对
        }
        //检查vincode字符是否超表
        for ($i=0; $i<17; $i++){
            if (!in_array($sVin{$i}, $aCharKeys)){
                return false; //超出范围
            }
        }
        //计算权值总和
        $iTotal = 0;
        for ($i=0; $i<17; $i++){
            $iTotal += $aCharMap[$sVin{$i}] * $aWeightMap[$i];
        }
        //计算校验码
        $sMode = $iTotal % 11;
        if ($sMode < 10 && $sMode === intval($sVin{8}) ){
            return true;
        }elseif (10 === $sMode && 'X' === $sVin{8}){
            return true;
        }else{
            return false;
        }
    }


    /**
     * 判断是否合法车牌号
     * 
     * 
     * @name isCarLicense
     * @author furong
     * @param $license
     * @return bool
     * @abstract
     * 增加对 特种车牌，武警车牌,军牌的校验
     * 增加对 6位新能源车牌的校验
    */
    public static function checkCarLicense($license)
    {
        if (empty($license)) {
            return false;
        }
        #匹配民用车牌和使馆车牌
        # 判断标准
        # 1，第一位为汉字省份缩写
        # 2，第二位为大写字母城市编码
        # 3，后面是5位仅含字母和数字的组合
        {
            $regular = "/[京津冀晋蒙辽吉黑沪苏浙皖闽赣鲁豫鄂湘粤桂琼川贵云渝藏陕甘青宁新使]{1}[A-Z]{1}[0-9a-zA-Z]{5}$/u";
            preg_match($regular, $license, $match);
            if (isset($match[0])) {
                return true;
            }
        }

        #匹配特种车牌(挂,警,学,领,港,澳)
        #参考 https://wenku.baidu.com/view/4573909a964bcf84b9d57bc5.html
        {
            $regular = '/[京津冀晋蒙辽吉黑沪苏浙皖闽赣鲁豫鄂湘粤桂琼川贵云渝藏陕甘青宁新]{1}[A-Z]{1}[0-9a-zA-Z]{4}[挂警学领港澳]{1}$/u';
            preg_match($regular, $license, $match);
            if (isset($match[0])) {
                return true;
            }
        }

        #匹配武警车牌
        #参考 https://wenku.baidu.com/view/7fe0b333aaea998fcc220e48.html
        {
            $regular = '/^WJ[京津冀晋蒙辽吉黑沪苏浙皖闽赣鲁豫鄂湘粤桂琼川贵云渝藏陕甘青宁新]?[0-9a-zA-Z]{5}$/ui';
            preg_match($regular, $license, $match);
            if (isset($match[0])) {
                return true;
            }
        }

        #匹配军牌
        #参考 http://auto.sina.com.cn/service/2013-05-03/18111149551.shtml
        {
            $regular = "/[A-Z]{2}[0-9]{5}$/";
            preg_match($regular, $license, $match);
            if (isset($match[0])) {
                return true;
            }
        }
        #匹配新能源车辆6位车牌
        #参考 https://baike.baidu.com/item/%E6%96%B0%E8%83%BD%E6%BA%90%E6%B1%BD%E8%BD%A6%E4%B8%93%E7%94%A8%E5%8F%B7%E7%89%8C
        {
            #小型新能源车
            $regular = "/[京津冀晋蒙辽吉黑沪苏浙皖闽赣鲁豫鄂湘粤桂琼川贵云渝藏陕甘青宁新]{1}[A-Z]{1}[DF]{1}[0-9a-zA-Z]{5}$/u";
            preg_match($regular, $license, $match);
            if (isset($match[0])) {
                return true;
            }
            #大型新能源车
            $regular = "/[京津冀晋蒙辽吉黑沪苏浙皖闽赣鲁豫鄂湘粤桂琼川贵云渝藏陕甘青宁新]{1}[A-Z]{1}[0-9a-zA-Z]{5}[DF]{1}$/u";
            preg_match($regular, $license, $match);
            if (isset($match[0])) {
                return true;
            }
        }
        return false;
    }

    /**
     * 身份证验证
     * @param  {[type]} $idCard 身份证号码
     * @return {[type]}
     */
    public static function checkIdCard($idCard)
    {
        // 只能是18位
        if (strlen($idCard) != 18) {
            return false;
        }
        // 取出本体码
        $idCard_base = substr($idCard, 0, 17);
        // 取出校验码
        $verify_code = substr($idCard, 17, 1);
        // 加权因子
        $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
        // 校验码对应值
        $verify_code_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
        // 根据前17位计算校验码
        $total = 0;
        for ($i = 0; $i < 17; $i++) {
            $total += substr($idCard_base, $i, 1) * $factor[$i];
        }
        // 取模
        $mod = $total % 11;
        // 比较校验码
        if ($verify_code == $verify_code_list[$mod]) {
            return true;
        } else {
            return false;
        }
    }



    public static function getNameStrokes($name) {
        $result = array();
        //var_dump(mb_detect_encoding($name),mb_substr($name,0,1));exit;
        $bihua = new Bihua();
        for( $i=0;$i<mb_strlen($name);$i++ ){
            $word = mb_substr($name,$i,1);
            $result[$i] = $bihua->find( $word );
        }
        return $result;
    }

    public static function getRandName($length){

        $pattern = '1234567890abcdefghijklmnopqrstuvwxyz';

        for($i=0;$i<$length;$i++){ 
            $key .= $pattern{mt_rand(0,35)}; 
        } 

        return $key;

    }

    // 字符串去重
    public static function string_unique($string){
        $arr = explode(',', $string);  
        $arr = array_unique($arr);//内置数组去重算法  
        $data = implode(',', $arr);  
        $data = trim($data,',');//trim — 去除字符串首尾处的空白字符（或者其他字符）,假如不使用，后面会多个逗号  
        return $data;//返回值，返回到函数外部  
    }

    // 高德坐标转百度坐标
    public static function bdEncrypt($gg_lon,$gg_lat){
        $x_pi = 3.14159265358979324 * 3000.0 / 180.0;
        $x = $gg_lon;
        $y = $gg_lat;
        $z = sqrt($x * $x +$y * $y) - 0.00002 * sin($y * $x_pi);
        $theta = atan2($y, $x) - 0.000003 * cos($x * $x_pi);
        $data['lon'] = $z * cos($theta) +0.0065;
        $data['lat'] = $z * sin($theta)+ 0.006;
        return $data;
    }

}
