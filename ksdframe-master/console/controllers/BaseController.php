<?php
namespace console\controllers;

use Yii;
use \yii\console\Controller;
use common\models\User;
use common\models\UserModel;
use yii\helpers\Console;

class BaseController extends Controller {
    //

    protected function message($message){
        $this->log($message);
        //echo date('H:i:s ').$message."\r\n";;
        Console::output(date('H:i:s ').$message);
    }

    protected function log($message,$type='message'){
        $message = date('Y-m-d H:i:s ').$message."\r\n";
        $logfile = dirname(__FILE__).'/../runtime/'.$type.date('Ymd').'.log';
        error_log($message,3,$logfile);
        Yii::info($message);
    }



    protected function _show_data($dataArray,$wordLength=16,$subFlag=1){
$dataString = "Data List:\n";
        $baseRow = current($dataArray);
        $lineLength = isset($baseRow)?count($baseRow)*($wordLength+3):60;
        //var_dump($lineLength);
        foreach( $dataArray as $row ) {
            $dataString .= str_pad('+',$lineLength,'-')."+\n";
            foreach( $row as $k=>$v ) {
                $row[$k] = strlen($v)>=$wordLength?($subFlag?(mb_substr($v,0,$wordLength)):$v):str_pad($v,$wordLength);
            }
            $dataString .= "| ".implode(" | ",$row)." |\n";
        }
        $dataString .= str_pad('+',$lineLength,'-')."+\n";
        $dataString = Console::ansiFormat($dataString,[Console::FG_YELLOW]);
        $this->message($dataString);
    }

}