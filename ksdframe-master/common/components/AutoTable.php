<?php
/**
 * AutoTable.php create by PHPStorm
 * project:ksdframe
 * Time: 2020/5/26
 */

namespace common\components;
use Yii;
use yii\db\Exception;

include dirname(__FILE__).'/autotable/AutoTemplate.php';

class AutoTable {

    protected $name = '';
    protected $config = [];
    protected $source = 'database'; //file|database

    protected $sqls;
    protected $files;

    protected $template;

    protected static $_instance;

    public function __construct($tableName,$config=[])
    {
        $this->name = $tableName;
        $this->template = new \AutoTemplate($tableName);
        $configMethod = 'setConfigBy'.ucfirst($this->source);
        if(method_exists($this,$configMethod)){
            $this->$configMethod();
        }
        $this->config['tableValues'] = [];
        foreach($this->config['tableCols'] as $col) {
            $this->config['tableValues'][$col] = '';
        }
        if(empty($this->config['primaryKey'])) {
            $this->config['primaryKey'] = $this->name.'Id';
        }
    }

    public static function getInstance($tableName){
        if( empty(self::$_instance[$tableName]) || !self::$_instance[$tableName] instanceof self) {
            self::$_instance[$tableName] = new AutoTable($tableName);
        }
        return self::$_instance[$tableName];
    }


    public function getConfig(){
        return $this->config;
    }

    public function setConfigByFile(){
        $file = $this->getConfigFile($this->name);
        $this->config = include($file);
        $this->config['tableCols'] = explode(',',$this->config['tableCols']);
        $this->config['showCols'] = explode(',',$this->config['showCols']);
    }

    public function setConfigByDatabase(){
        $sql = "select * from moudle where moudleKey='{$this->name}'";
        $command = Yii::$app->db->createCommand($sql);
        $row = $command->queryOne();
        if( empty($row) ) {
            throw new CException('moudle config ['.$this->name.'] not exists.');
        }
         //var_dump($row); exit;
        $this->config = $row;
        $this->config['tableCols'] = explode(',',$this->config['tableCols']);
        $this->config['showCols'] = explode(',',$this->config['showCols']);
        $this->config['colsNames'] = json_decode($this->config['colsNames'],true);
        $this->config['colsTypes'] = json_decode($this->config['colsTypes'],true);
        //var_dump($this->config,$row);exit;
    }


    public function create(){
        try {
            $this->runSql($this->getRenameSql());
        }
        catch (Exception $e) {
            //rename error,do nothing
        }
        $this->runSql($this->getCreateSql());
        return $this->runSql($this->getInsertSql());
    }



    public function getConfigFile($name){
        $file = dirname(__FILE__).'/../../common/config/tables/'.$name.'.php';
        if( !file_exists($file) ) {
            throw new CException('data file ['.$name.'] not exists.');
        }
        return $file;
    }


    public function getTemplateCode($filename){
        $config = $this->getConfig();
        $params = [
            'name'=>$this->name,
            'primaryKey' => empty($config['primaryKey'])?($this->name.'Id'):$config['primaryKey'],
            'config'=>$config
        ];
        $fileList = array(
            'base' => SYSTEM_ROOT.'/common/models/'.ucfirst($this->name).'.php',
            'model' => SYSTEM_ROOT.'/common/models/'.ucfirst($this->name).'Model.php',
            'controller' => SYSTEM_ROOT.'/backend/controllers/'.ucfirst($this->name).'Controller.php',
            'list' => SYSTEM_ROOT.'/backend/views/'.$this->name.'/'.$this->name.'List.php',
            'add' => SYSTEM_ROOT.'/backend/views/'.$this->name.'/add'.ucfirst($this->name).'.php',
            'edit' => SYSTEM_ROOT.'/backend/views/'.$this->name.'/edit'.ucfirst($this->name).'.php',
        );
        if( isset($fileList[$filename]) ){
            return [
                'file'=>$fileList[$filename],
                'code'=>$this->template->getCode($filename,$params),
            ];
        }
        else {
            return '';
        }
    }

    public function getRenameSql(){
        return "rename table `{$this->name}` to `{$this->name}_".date('ymdhis')."`;";
    }

    public function getCreateSql(){
        $config = $this->getConfig();
        $primaryKey = empty($config['primaryKey'])?($this->name.'Id'):$config['primaryKey'];
        $sql = "create table `{$this->name}` (\n`{$primaryKey}` int(10) NOT NULL AUTO_INCREMENT,\n";
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
        $sql .= "PRIMARY KEY (`{$primaryKey}`) \n) COMMENT = '{$config['moudleName']}';\n";
        return $sql;
    }

    public function getInsertSql(){
        $config = $this->getConfig();
        $cols = ['createTime'];
        $values = [time()];
        foreach($config['tableCols'] as $col){
            $cols[] = $col;
            $values[] = isset($config['colsNames'][$col])?$config['colsNames'][$col]:((substr($col,-4)=='Flag'?'1':$col.rand(1,999999)));
        }
        return "insert into {$this->name}(`".implode("`,`",$cols)."`) values('".implode("','",$values)."');" ;
    }



    protected function runSql($sql){
        $command = Yii::$app->db->createCommand($sql);
        return $command->execute();
    }
}


