<?php


namespace backend\controllers;

use Yii;
use common\models\FileModel;
use common\models\Card;
use common\models\StudentModel;
use common\models\ChargeLog;
use yii\web\UploadedFile;
class FileController extends BaseController{

    protected $cardColNameList = array(
        '卡号' => 'cardName',
        '学校ID' => 'schoolId',
        '学生姓名' => 'name',
        '学生学号' => 'studentNumber',
        '家长姓名' => 'parentName',
        '联系电话' => 'parentMobile',
        /*'开卡金额' => 'cardMoney',
        '通话时间' => 'leftMins',*/
        '备注' => 'content',
    );

    public function actionAdd(){

        $data = $_FILES;
        $fileKeyName = array_keys($data);
        $file = array_pop($data);

        if ((isset($file['error']) && $file['error'] == 0) || (!isset($file['error']) && $file['tmp_name'] != 'none')){

            $fileArray = explode('.',$file['name']);
            $ext = (array_pop($fileArray));
            $adminId = Yii::$app->session->get('adminId');
            $file_name = "file".$adminId.'_'.time().'.'.$ext;
            $save_name = Yii::getAlias("@webroot").'/upload/file/student/'.$file_name;

            if(move_uploaded_file($file['tmp_name'], $save_name)){

                $file = array(
                    'keyName' => $fileKeyName[0], 
                    'fileName' => $save_name
                );

                $this->echoJsonData($file);

            }else{

                $this->error('上传失败');
            }
         }
    }

    public function actionUploadFile(){
        $data = $_FILES;
        $fileKeyName = array_keys($data);
        $file = array_pop($data);
        $type = Yii::$app->request->get('type');

        if ((isset($file['error']) && $file['error'] == 0) || (!isset($file['error']) && $file['tmp_name'] != 'none')){

            $fileArray = explode('.',$file['name']);
            $ext = (array_pop($fileArray));
            $adminId = Yii::$app->session->get('adminId');
            $file_name = "file".$adminId.'_'.time().'.'.$ext;
            $save_name = Yii::getAlias("@webroot").'/upload/file/'.$file_name;

            if(move_uploaded_file($file['tmp_name'], $save_name)){

                $file = array(
                    'keyName' => $fileKeyName[0],
                    'fileName' => $file_name,
                    'fullName' => $save_name,
                );

                $data = $this->_import_card($save_name);
                $this->displayData($data);

            }else{
                $this->error('上传失败');
            }
         }
    }

    public function _import_card($file){
        $handle = $this->_get_file($file);
        if( empty($handle) ) return ;
        $cols = $this->_convert_cols($this->cardColNameList,fgetcsv($handle));
        $result = ['importCount' => 0,'rowCount' => 0,'error' => 0];
        while($row=fgetcsv($handle)){
            $result['rowCount'] ++ ;
            $row = $this->_convert($row,$cols);
            $cardName = $row['cardName'];
            $cardSn = $row['cardName'];
            $cardInfo = Card::multiLoadRow("cardNumber = $cardName OR cardSn = $cardSn");
            if (empty($row['cardName']) || !empty($cardInfo)) {
                $cardInfo->log('导入失败，卡号'.$row['cardName'].'已存在');
                $result['error'] ++;
                continue;
            }
            $card = Card::addCard($row['cardName'],$row['cardName']);
            if( !empty($row['name']) ) {
                $student = StudentModel::getInstance()->addStudent($row['schoolId'],$row['name'],$row['parentName'],$row['parentMobile'],$row['studentNumber']);
                $card->setStudent($student->studentId,$row['schoolId']);
            }
            /*if ( !empty($row['cardMoney'])||!empty($row['leftMins']) ) {
                ChargeLog::addChargeLog($card->userId,$card->cardNumber,1,$row['leftMins'],$row['cardMoney'],time(),$row['content'].'-批量录入');
                $card->cardCharge($row['leftMins'],$row['cardMoney'],$row['content']);
            }*/
            
            $result['importCount'] ++;
        }
        fclose($handle);
        return $result;
    }

    private function _get_file($file){
        if( is_file($file) ){
            $this->_convert_format($file);
            return fopen($file,'r');
        }
        elseif( is_file(getcwd().'/'.$file) ){
            $this->_convert_format(is_file(getcwd().'/'.$file));
            return fopen(getcwd().'/'.$file,'r');
        }
        else {
            return false;
        }
    }

    private function _convert_format($file) {
        $content = file_get_contents($file);
        $convertContent = @iconv('GBK','UTF-8',$content);
        if( !empty($convertContent)&&md5($content)!=md5($convertContent) ) {
            file_put_contents($file,$convertContent);
        }
    }

    private function _convert($row,$cols=array()){
        $result = [];
        foreach( $row as $k=>$v ){
            if( isset($cols[$k]) ) {
                $result[$cols[$k]] = trim($v);
            }
            else {
                $result[$k] =  trim($v);
            }
        }
        return $result;
    }

    private function _convert_cols($colNameList,$headerList){
        $headerList = $this->_convert($headerList);
        $cols = array();
        foreach($headerList as $index=>$name){
            if( !isset($colNameList[$name]) ) {
                continue;
            }
            $cols[$index] = $colNameList[$name];
        }
        return $cols;
    }
}