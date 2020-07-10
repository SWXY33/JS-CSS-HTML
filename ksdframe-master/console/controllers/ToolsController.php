<?php
namespace console\controllers;

use common\components\AutoTable;
use console\models\ToolsModel;
use Yii;

class ToolsController extends BaseController {
    
    public function actionTest($name='demo'){
        $table = AutoTable::getInstance($name);
        //var_dump($table->create());
        var_dump($table->getTemplateCode('controller'));
    }

    public function actionCode(){
        //
    }


    public function actionCreateMoudle($name='demo',$createTable='0'){
        $this->message('create moudle '.$name);
        $table = AutoTable::getInstance($name);
        if( !empty($createTable) ) {
            $table->create();
            $this->message('create database table success; '.$name);
        }

        $files = ['controller','base','model','list','add','edit'];
        foreach ($files as $filename){
            $result = $table->getTemplateCode($filename);
            if( !is_dir(dirname($result['file'])) ) {
                mkdir(dirname($result['file']),0755,true);
            }
            file_put_contents($result['file'],$result['code']);
            $this->message('create '.$filename.' file to:'.$result['file']);
        }

        $this->message('create moudle '.$name.' finished!');
    }

}

