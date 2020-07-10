<?php
namespace console\models;

use common\components\CException;
use common\components\Model;

class ToolsModel extends Model
{
    public function getMoudleData($name){
        $file = dirname(__FILE__).'/../../common/config/tables/'.$name.'.php';
        if( !file_exists($file) ) {
            throw new CException('data file ['.$name.'] not exists.');
        }
        else {
            $config = include($file);
            //var_dump($config); exit;
            $config['tableCols'] = explode(',',$config['tableCols']);
            $config['showCols'] = explode(',',$config['showCols']);
            $result = [
                'sql'=>[
                        'drop' => "rename table `$name` to `$name".date('ymdhis')."`;",
                        'create' => $this->getCreateSql($name,$config),
                        'testInsert' => $this->getInsertSql($name,$config),
                    ],
                'files'=>[
                    'model' => '',
                    'base'  => '',
                    'controller' => '',
                ]
            ];
            return $result;
        }

    }


    public function getTemplate($name){
        switch ($name) {
            case 'model':
            case 'controller':
            case 'base':
                break;
            default:
                return '';
        }
    }

    public function getCreateSql($name,$config){
        $primaryKey = empty($config['primaryKey'])?($name.'Id'):$config['primaryKey'];
        $sql = "create table `{$name}` (\n`{$primaryKey}` int(10) NOT NULL AUTO_INCREMENT,\n";
        //var_dump($config['tableCols']); exit;
        foreach( $config['tableCols'] as $col ){
            $type = empty($config['colTypes'][$col])?(substr($col,-4)=='Flag'?'tinyint(1)':'varchar(255)'):$config['colTypes'][$col];
            $comment = empty($config['colNames'][$col])?'':$config['colNames'][$col];
            $default = empty($config['colDefaults'][$col])?(substr($col,-4)=='Flag'?1:''):$config['colDefaults'][$col];
            $sql .= "`{$col}` {$type} DEFAULT '{$default}' COMMENT '{$comment}',\n";
        }
        $sql .= "`deleteFlag` tinyint(1) DEFAULT 0 COMMENT '是否删除',\n";
        $sql .= "`createTime` int(10),\n";
        $sql .= "`updateTime` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,\n";
        $sql .= "PRIMARY KEY (`{$primaryKey}`) \n);\n";
        return $sql;
    }

    public function getInsertSql($name,$config){
        $cols = ['createTime'];
        $values = [time()];
        foreach($config['tableCols'] as $col){
            $cols[] = $col;
            $values[] = isset($config['colsNames'][$col])?$config['colsNames'][$col]:((substr($col,-4)=='Flag'?'1':$col.rand(1,999999)));
        }
        return "insert into $name(`".implode("`,`",$cols)."`) values('".implode("','",$values)."');" ;
    }


}