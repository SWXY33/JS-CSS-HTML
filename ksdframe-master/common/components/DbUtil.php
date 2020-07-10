<?php
/**
 * Class DbUtil
 *
 * 数据库接口类
 */
namespace common\components;
use Yii;
class DbUtil{
    /**
     * DbUtil::insert()
     * 插入一条数据记录
     * 
     * @param mixed $db
     * @param mixed $tableName
     * @param mixed $insertSqlArr
     * @param bool $returnId
     * @param bool $replace
     * @return 最后插入的数据id 或者 null
     */
    public static function insert($db, $tableName, $insertSqlArr, $returnId = false, $replace = false){
        $insertKeySql = $insertValueSql = $comma = '';
        $insertValues = array();
        $count = 1;
        foreach ($insertSqlArr as $insertKey => $insertValue) {
            $insertKeySql .= $comma.'`'.$insertKey.'`';
            $insertValueSql .= $comma.'?';
            $insertValues[$count] = $insertValue;
            $comma = ', ';
            $count++;
        }
        $method = $replace ? 'REPLACE': 'INSERT';
        $command = $db->createCommand($method.' INTO `'.$tableName.'` ('.$insertKeySql.') VALUES ('.$insertValueSql.')');
        $command->bindValues($insertValues);
        $command->execute();
        if($returnId && !$replace) {
            $command = $db->createCommand('SELECT last_insert_id()');
            return $command->queryScalar();
        }
    }
    
    /**
     * DbUtil::batchInsert()
     * 批量插入多条数据记录
     * 
     * @param mixed $db
     * @param mixed $tableName
     * @param mixed $columnNames
     * @param mixed $insertDatas
     * @param bool $replace
     * @return
     */
    public static function batchInsert($db, $tableName, $columnNames, $insertDatas, $replace = false) {
        if (count($insertDatas) == 0) {
            return 0;
        }
        
        $columnCount = count($columnNames);
        $insertKeySql = implode(',', $columnNames);
        $singleBindSql = '(' . implode(',', array_fill(0, $columnCount, '?')) . ')';
        $insertValueSql = implode(',', array_fill(0, count($insertDatas), $singleBindSql));
        
        $insertValues = array();
        $count = 1;
        foreach ($insertDatas as $insertData) {
            for ($i = 0; $i < $columnCount; $i++) {
                $insertValues[$count] = $insertData[$i];
                $count++;
            }
        }
        $method = $replace ? 'REPLACE': 'INSERT';
        $command = $db->createCommand($method.' INTO `'.$tableName.'` ('.$insertKeySql.') VALUES '.$insertValueSql);
        $command->bindValues($insertValues);
        return $command->execute();
    }

    /**
     * DbUtil::update()
     * 更新表数据
     * 
     * @param mixed $db
     * @param mixed $tableName
     * @param mixed $setSqlArr
     * @param mixed $whereSqlArr
     * @return
     */
    public static function update($db, $tableName, $setSqlArr, $whereSqlArr = array()){
        if(empty($setSqlArr)){
            return;
        }
        $setSql = $comma = '';
        $bindValues = array();
        $count = 1;
        foreach ($setSqlArr as $setKey => $setValue) {
            $setSql .= $comma.'`'.$setKey.'`'.'= ? ';
            $comma = ', ';
            $bindValues[$count] = $setValue;
            $count++;
        }
        $whereSql = $comma = '';
        if(empty($whereSqlArr)) {
            $whereSql = '1';
        } elseif(is_array($whereSqlArr)) {
            foreach ($whereSqlArr as $key => $value) {
                $whereSql .= $comma.'`'.$key.'`'.'= ? ';
                $comma = ' AND ';
                $bindValues[$count] = $value;
                $count++;
            }
        } else {
            $whereSql = '1';
        }
        
        $command = $db->createCommand('UPDATE `'.$tableName.'` SET '.$setSql.' WHERE '.$whereSql);
        $command->bindValues($bindValues);
        return $command->execute();

    }
    
    /**
     * DbUtil::getTableCols()
     * 获取一个数据表的所有列名
     * 
     * @param mixed $tableName
     * @return array
     */
    public static function getTableCols($tableName){
        static $tableColsData = array();
        $filterArray = array('updateTime');
        if( empty($tableColsData[$tableName]) ) {
            $sql = "desc `$tableName`";
            $result = Yii::$app->db->createCommand($sql)->queryAll();
            if( !empty($result) ) {
                foreach( $result as $r ) {
                    if( empty($r['Field'])||in_array($r['Field'],$filterArray) ) continue;
                    $tableColsData[$tableName][] = $r['Field'];
                }
            }
        }
        //var_dump($result,$returnArray);
        return $tableColsData[$tableName];
    }
    
    /**
     * DbUtil::getTableColsArray()
     * 获取一张数据表的所有列数组
     * 
     * @param mixed $tableName
     * @return array
     */
    public static function getTableColsArray($tableName,$filter=array(),$index='Field' ){
        static $tableColsData = array();
        $filterArray = array_merge( array('deleteFlag','createTime','updateTime'),$filter );
        if( empty($tableColsData[$tableName]) ) {
            $sql = "SHOW FULL COLUMNS from `$tableName`";
            $result = Yii::$app->db->createCommand($sql)->queryAll();
            $i = 0;
            if( !empty($result) ) {
                foreach( $result as $r ) {
                    if( empty($r['Field'])||in_array($r['Field'],$filterArray) ) continue;
                    //$type = strpos($r['Type'],'int')!==false?'':;
                    $idx = empty($index)?$i++:$r[$index];
                    $tableColsData[$tableName][$idx] = array(
                        'name' => $r['Field'],
                        'desc' => $r['Comment'],
                        'type' => '',
                        //'comment',
                        'required' => '',
                        'data' => '',
                        'label' => $r['Comment'],
                        //'listshow',
                    );
                }
            }
        }
        //var_dump($result,$returnArray);
        return $tableColsData[$tableName];
    }
}