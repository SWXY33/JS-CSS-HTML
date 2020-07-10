<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */

namespace common\components;

use Yii;

class Controller extends \yii\web\Controller {

    public $layout='main';

    public $request;

    public $baseUrl;

    protected $pageTitle = '';


    public $actionType = REQUEST_TYPE_NORMAL;
    public $showGlobalMessage = true;
    public $showGlobalState = true;

    /**
     * Controller::init()
     * 初始化方法，会在所有action被调用前调用到 
     * 主要是判断当前请求类型及初始化一些公共变量
     * 子类可以根据自身需要重写该方法
     * 
     * @return void
     */
    public function init() {
        $this->request = Yii::$app->getRequest();
        if (!empty($_REQUEST['noMessage'])) {
            $this->showGlobalMessage = false;
        }
        if (!empty($_REQUEST['isAjax'])||$this->request->getIsAjax()) {
            $this->actionType = REQUEST_TYPE_AJAX;
        }
        if (!empty($_REQUEST['isJsonP'])&&!empty($_REQUEST['callback'])) {
            $this->actionType = REQUEST_TYPE_JSONP;
        }
        if (!empty($_REQUEST['isWxApp'])) {
            $this->actionType = REQUEST_TYPE_WXAPP;
        }
        $this->baseUrl = $this->getBaseUrl();
        Yii::$app->params['baseUrl'] = $this->baseUrl;
    }

    /**
     * Controller::redirect()
     * URL跳转方法，所有子类中都可以直接使用$this->redirect($ulr)进行一个302跳转
     * 其中URL是一个完整的网址 可以手动填写或者通过 createUrl方法创建
     * @param mixed $url
     * @param string $type
     * @param integer $statusCode
     * @return void
     */
    public function redirect($url,$type='header',$statusCode = 302) {
        switch ( $this->actionType ) {
            case REQUEST_TYPE_NORMAL:
                if($type=='js'||$type=='javascript') {
                    exit('<script language="javascript">window.location.href="' .$url. '";</script>');
                } elseif($type=='jstop') {
                    exit('<script language="javascript">top.location.href="' .$url. '";</script>');
                }
                else {
                    header('Location:'.$url);
                    exit;
                    //parent::redirect($url,$statusCode);
                }
                break;
            case REQUEST_TYPE_AJAX:
            case REQUEST_TYPE_JSON:
            case REQUEST_TYPE_JSONP:
            case REQUEST_TYPE_WXAPP:
                $this->echoJsonData(array('url' => $url), 999);
                break;
            default:
                throw new CException('error request type');
        }
    }

    /**
     * Controller::displayHtml()
     * 显示HTML页面内容，通常用于网站页面显示
     * 
     * @param string $view 模板文件名
     * @param mixed $params 要传递到模板中的对应参数
     * @return void
     */
    protected function displayHtml($view='',$params=array()){
        if( !isset($params['systemVersion']) ) {
            $params['systemVersion'] = defined('YII_DEBUG')&&YII_DEBUG?time():Yii::$app->params['version'];
        }
        $params['controller'] = $this;

        switch( $this->actionType ){
            case REQUEST_TYPE_NORMAL:
                $this->echoHtmlData($view,$params);
                break;
            default:
                $data = $this->renderPartial($view,$params,true);
                $this->echoJsonData($data);
                break;
        }
    }

    /**
     * 显示数据，用于ajax数据返回和一些接口返回
     * 
     * @param mixed $data 数据内容
     * @param mixed $params 对应的扩展参数
     * @return void
     */
    protected function displayData($data = array(), $params = array()){
        if( !isset($params['systemVersion']) ) {
            $params['systemVersion'] = defined('YII_DEBUG')&&YII_DEBUG?time():Yii::$app->params['version'];
        }
        $this->echoJsonData($data, 1, 'success', $params);
    }

    /**
     * Controller::echoJsonData()
     * 输出json数据 封装并格式化用户要输出的数据 
     * 
     * @param mixed $data 要输出的数据内容
     * @param integer $stateCode 外层封装状态码 默认1 
     * @param string $message 外层提示消息 
     * @param mixed $params 扩展参数 会直接与外层数组合并 
     * @return void 
     */
    protected function echoJsonData($data = array(), $stateCode = 1, $message = 'success', $params = array()) {
        $result = array('stateCode' => $stateCode, 'message' => $message, 'data' => $data);
        if (!empty($params)) {
            $result = array_merge($result, $params);
        }
        if (!empty($_GET['showData'])) {
            self::dump($result);
        }
        elseif(!empty($_POST['debugData'])){
            unset($_POST['debugData']);
            $this->echoJsonData( print_r($result,true) );
        }else {
            $jsonData = json_encode($result);
            if( $this->actionType == REQUEST_TYPE_JSONP ) {
                $callback = addslashes(strip_tags($_REQUEST['callback']));
                $jsonData = $callback.'('.$jsonData.')';
            }
            echo $jsonData;
            exit;
        }
    }

    /**
     * Controller::echoHtmlData()
     * 输出html数据 
     * 非json格式请求时 直接输出对应的模板
     * 可以用于任何类似XML格式数据
     * 
     * @param mixed $view
     * @param mixed $data
     * @return void
     */
    protected function echoHtmlData($view, $data = array()) {
        if (!empty($view)) {
            echo $this->render($view, $data);
        }
        else {
            throw CException('empty view name.');
        }
    }

    /**
     * Controller::success()
     * 操作成功调用方法
     * 
     * @param string $message
     * @return void
     */
    protected function success($message='success',$data = array()){
        $this->message($message,1,$data);
    }

    /**
     * Controller::error()
     * 操作失败调用方法
     * 
     * @param mixed $message 错误的消息内容
     * @return  void
     */
    protected function error($message='系统错误',$data = array()){
        $this->message($message,'-1',$data);
    }

    /**
     * Controller::errorMessage()
     * 报出系统异常
     * 
     * @param mixed $message
     * @return void
     */
    protected function errorMessage($message){
        $this->message($message,'-9');
    }

    /**
     * Controller::message()
     * 显示并输出消息 
     * 包括成功 失败 异常等消息都是通过该方法实现
     * 
     * @param string $message
     * @param integer $stateCode
     * @param mixed $data
     * @return void
     */
    protected function message($message = 'system error', $stateCode = 1, $data = array()) {
        $this->showGlobalMessage = false ;
        switch ($this->actionType) {
            case REQUEST_TYPE_AJAX :
                $resultParams = array() ;
                $this->echoJsonData($data, $stateCode, $message,$resultParams);
                break;
            default:
                $resultParams = array() ;
                $this->echoJsonData($data, $stateCode, $message,$resultParams);
        }
    }


    /**
     * Controller::createUrl()
     * 根据传入的字符串或参数创建完整的URL 
     * 
     * @param mixed $route 字符串路径 如：user/index
     * @param mixed $params 对应的更多参数数组 如 id=123
     * @return string  完整的URL
     */
    public function createUrl($route, $params = array()) {
        //$params['SID'] = Yii::$app->session->getSessionId();
        if ($route === '') {
            $route = $this->getRoute();
        }
        else if (strpos($route, '/') === false){
            $route = $this->getUniqueId() . '/' . $route;
        }
        else {
            //do nothing
        }
        return Yii::$app->getUrlManager()->createAbsoluteUrl( array($route) );
    }

    /**
     * 获取当前请求的基准URl
     * @return string
     */
    public function getBaseUrl(){
        return Yii::$app->getRequest()->hostInfo.Yii::$app->getUrlManager()->getBaseUrl();
    }

    /**
     * 调试输出信息
     * 
     * @param mixed $var
     * @param string $title
     * @return void
     */
    protected static function dump($var, $title = 'DEBUG DUMP') {
        echo "<fieldset><legend style='font-size:16px;color:#f00'> $title </legend><pre style='font-size:14px; color:#666;'>";
        var_dump($var);
        //print_r($var);
        echo "</pre></fieldset>";
    }

    protected function varRequest($key) {
        return isset($_REQUEST[$key])?$_REQUEST[$key]:null;
    }

    /**
     * 验证输入信息
     * @param  array $rules
     * @return response
     */
    public function validateInput($rules)
    {
        $requests = Yii::$app->request->post();

        $Validator = new Validator();
        foreach ($rules as $key => $rule) {
            if (isset($requests[$key])) {
                $checkArray = array($key=>$rule);
                $info = $Validator->check($checkArray);
                if (isset($info[0]) && !$info[0]) {
                    $this->error($info[1]);
                    break;
                }
            }
            continue;
        }
        
        return $requests;
    }

}
